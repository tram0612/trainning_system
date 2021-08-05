<?php

namespace App\Http\Controllers\Server;

use App\Enums\Finish;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Traits\UploadFile;
use App\Http\Requests\CourseRequest;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    use UploadFile;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function dashboard(){
        $unfinishedCourses = Course::withTrashed()->where('finish',Finish::No)->get();
        $doneCourses = Course::withTrashed()->where('finish',Finish::Yes)->get();
        return view('server.index',compact('unfinishedCourses','doneCourses'));
    }
    public function index()
    {
        $courses = Course::withTrashed()->paginate(10);
        return view('server.course.index',compact('courses'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $courses = ''; 
        if($status == null && $search == null){
            $html = view('server.layouts.alertSearch')->render();
            return response()->json(['success' => false,'html' => $html]);
        }
        if($status == null){
            
            $courses = Course::withTrashed()->where('name','like','%'.$search.'%')->get();
        }
        else{
            $courses = Course::withTrashed()->where('finish',$status)->where('name','like','%'.$search.'%')->get();
        }      
        $html = view('server.course.search')->with(compact('courses'))->render();

        return response()->json(['success' => true,'html' => $html]);
    }
    public function finish(Request $request,$id){
        $course = $this->loadCourseWithTrash($id);
        $course->finish = Finish::Yes;
        $course->save();
        return response()->json(['success' => true]);
    }
    public function detail($id){
        $course = $this->loadCourseWithTrash($id);
        return view('server.course.detail',compact('course'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('server.course.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $temp = $req->except(['_token']);
        if($req->hasfile('img')){
            $image=$req->file('img');
            $temp['img'] = $this->upload($image);
        }
        $insert = Course::create($temp);
        if(isset($insert)){
            return redirect()->route('server.course.subject.index',[$insert->id]);
        }else{
            return back()->with('msg', __('messages.add.fail'));
        }
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = $this-> loadCourseWithTrash($id);
        return view('server.course.edit',compact('course')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function progress($courseId,$userId)
    {
        $course = $this->loadCourseWithTrash($courseId);
        $user = $this->loadUserWithTrash($userId);
        $subjects = Course::loadSubjectforUserInCourse($courseId,$userId);
        return view('server.course.user.progress',compact('course','user','subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function update(CourseRequest $req, $id)
    {
        $course = $this->loadCourseWithTrash($id);
        $temp = $req->except(['_token']);
        if($req->hasfile('img')){
            $image=$req->file('img');
            if($course->img!=null){
                $img = $course->img;
                $path = public_path('upload/' . $img);
                if(file_exists($path)){
                    unlink(public_path('upload/' . $img));
                }
            }
            $image = $req->file('img');
            $temp['img'] = $this->upload($image);

        }
        $update = $course->update($temp);
        if($update){
            return redirect()->route('server.course.index')->with('msg', __('messages.update.success'));
        }else{
            return back()->with('fail', __('messages.update.fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
        $course = $this->loadCourseWithTrash($id);
        if($course->img!=null){
            $img =$course->img;
            $path = public_path('upload/' . $img);
            if(file_exists($path)){
                unlink(public_path('upload/' . $img));
            }
        }
        $this->checkDataInTransaction($course,__FUNCTION__);
    }
    
    public function softDelete($id){
        $course = $this->loadCourseWithTrash($id);
        $this->checkDataInTransaction($course,__FUNCTION__);
    }
    public function restore($id){
        $course =$this->loadCourseWithTrash($id);
        $this->checkDataInTransaction($course,__FUNCTION__);
    }
}
