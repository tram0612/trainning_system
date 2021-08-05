<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\CourseSubject;
use App\Enums\Status;
use App\Http\Requests\CourseSubjectRequest;
use Illuminate\Support\Facades\DB;

class CourseSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index($courseId)
    {
        $course = $this->loadCourseWithTrash($courseId);
        $subjectOfCourse=$course->subject()->get();
        $subjects = Subject::all()->toArray();
        foreach($subjectOfCourse as $subjectCourse) {
            foreach ($subjects as $key=> $subject){
                if($subjectCourse->id==$subject['id']){
                    unset($subjects[$key]);
                    break;
                }
            }
        }
        return view('server.course.subject',compact('course','subjects','subjectOfCourse'));
    }
    public function status(Request $req){
        $subject = CourseSubject::updateStatus($req->courseId,$req->subjectId);
        return response()->json(['success' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req,$courseId)
    {
        
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseSubjectRequest $req,$courseId)
    {
        $course = $this->loadCourseWithTrash($courseId);
        $subject = $this->loadSubjectWithTrash($req->subject);
        $position = 0;
        $subjects=$course->subject()->get()->toArray();
        if(!empty($subjects)){
            $position = $course->subject()->max('position');
        }
        $courseSubject = CourseSubject::create([
            'course_id' => $courseId,
            'subject_id'=> $req->subject,
            'started_at'=>date('Y-m-d', strtotime($req->started_at)),
            'position'=> ++$position
        ]);
        if($courseSubject){
            return redirect()->route('server.course.subject.index',[$courseId])->with('msg', __('messages.add.success'));
        }else{
            return redirect()->route('server.course.subject.index',[$courseId])->with('fail', __('messages.add.fail'));
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($courseId,$subjectId)
    {
        $courseSubject = $this->loadCourseSubject($courseId,$subjectId);
        return view('server.course.editSubject',compact('courseSubject'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sortSubject(Request $req){
        $CourseSubject = CourseSubject::sortSubject($req);
        return response()->json(['success' => true]);
    }
    public function update(CourseSubjectRequest $req, $courseId,$subjectId)
    {
        $subject = CourseSubject::updateDate($req, $courseId,$subjectId);
        if($subject){
            return redirect()->route('server.course.subject.index',[$courseId])->with('msg', __('messages.update.success'));
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
    public function loadCourseSubject($courseId,$subjectId)
    {
        $courseSubject = CourseSubject::withTrashed()->where('course_id',$courseId)->where('subject_id',$subjectId)->first();
        if(blank($courseSubject)){
            abort(redirect()->back()->with('fail', __('messages.oop!')));
        }else{
            return $courseSubject;
        }
    }
    public function destroy($courseId,$subjectId)
    {
        $courseSubject = $this->loadCourseSubject($courseId,$subjectId);
        $this->checkDataInTransaction($courseSubject,__FUNCTION__);
    }
    public function softDelete($courseId,$subjectId){
        $courseSubject = $this->loadCourseSubject($courseId,$subjectId);
        $this->checkDataInTransaction($courseSubject,__FUNCTION__);
    }
    public function restore($courseId,$subjectId){
        $courseSubject = $this->loadCourseSubject($courseId,$subjectId);
        $this->checkDataInTransaction($courseSubject,__FUNCTION__);
    }
    
}
