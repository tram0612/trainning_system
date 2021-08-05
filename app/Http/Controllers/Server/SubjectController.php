<?php

namespace App\Http\Controllers\Server;

use App\Enums\Search;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Http\Requests\SubjectRequest;
use App\Http\Traits\UploadFile;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    use UploadFile;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $subjects = Subject::withTrashed()->paginate(10);
        return view('server.subject.index',compact('subjects'));
        
    }
    public function detail($id)
    {
       $subject = $this->loadSubjectWithTrash($id);
        if(blank($subject)){
            return back()->with('msg', __('messages.oop!'));
        }
        return view('server.subject.detail',compact('subject'));
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('server.subject.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $req)
    {
        $temp = $req->except(['_token']);
        if($req->hasfile('img')){
            $image=$req->file('img');
            $temp['img'] = $this->upload($image);
        }
        $insert = Subject::create($temp);

        if(isset($insert)){
             return redirect()->route('server.subject.task.index',[$insert->id]);
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
        $subject = $this->loadSubjectWithTrash($id);
        return view('server.subject.edit',compact('subject')); 
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

    
    public function search(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $subjects = ''; 
        if($status == null && $search == null){
            $html = view('server.layouts.alertSearch')->render(); 
            return response()->json(['success' => false,'html' => $html]);
        }
        if($status != null){
            if($status == Search::NoTrash){
                if($search != null){
                    $subjects = Subject::where('name','like','%'.$search.'%')->get();
                }
                else{
                    $subjects = Subject::all();
                    
                }
            }else{
                if($search != null){
                    $subjects = Subject::onlyTrashed()->where('name','like','%'.$search.'%')->get();
                }
                else{
                    $subjects = Subject::onlyTrashed()->get();
                }
            }
        }else{
            $subjects = Subject::withTrashed()->where('name','like','%'.$search.'%')->get();
        }
        $html = view('server.subject.search')->with(compact('subjects'))->render();

        return response()->json(['success' => true,'html' => $html]);
    }
    public function update(SubjectRequest $req, $id)
    {
        $subject = $this->loadSubjectWithTrash($id);
        $temp = $req->except(['_token']);
        if($req->hasfile('img')){
            $image=$req->file('img');
            if($subject->img!=null){
                $img = $subject->img;
                $path = public_path('upload/' . $img);
                if(file_exists($path)){
                    unlink(public_path('upload/' . $img));
                }
            }
            $image = $req->file('img');
            $temp['img'] = $this->upload($image);

        }
        $update = $subject->update($temp);
        if($update){
            return redirect()->route('server.subject.index')->with('msg', __('messages.update.success'));
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
        $subject = $this->loadSubjectWithTrash($id);
        if($subject->img!=null){
            $img = $subject->img;
            $path = public_path('upload/' . $img);
            if(file_exists($path)){
                unlink(public_path('upload/' . $img));
            }
        }
        $this->checkDataInTransaction($subject,__FUNCTION__);
    }
    public function softDelete($id){
        $subject = $this->loadSubjectWithTrash($id);
        $this->checkDataInTransaction($subject,__FUNCTION__);
    }
    public function restore($id){
        $subject = $this->loadSubjectWithTrash($id);
        $this->checkDataInTransaction($subject,__FUNCTION__);
    }
}
