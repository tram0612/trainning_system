<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Task;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $subject = $this->loadSubjectWithTrash($id);
        return view('server.subject.task.index',compact('subject'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(TaskRequest $req,$id)
    {

        $subject = $this->loadSubjectWithTrash($id);
        $position = 0;
        if(!blank($subject->task()->get())){
            $position = $subject->task()->max('position');
        }
        $temp=$req->only(['name','detail']);
        $temp['subject_id'] = $id;
        $temp['position'] =++$position;
        $task = Task::create($temp);
        if(isset($task)){
             
            return redirect()->route('server.subject.task.index',[$id])->with('msg', __('messages.add.success')); 
        }else{
            return back()->with('fail', __('messages.oop!'));
        }
        
    }

    public function sortTask(Request $req){
        $arr = explode(',', $req->ids);
        for($i=0; $i<count($arr); $i++){
            Task::where('id',$arr[$i])->update(['position'=>$i]);
        }
        return response()->json(['success' => true]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($subjectId,$taskId)
    {
        $task = $this->loadTask($taskId);
        return view('server.subject.task.edit',compact('task','subjectId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }
    public function loadTask($taskId){
        $task = Task::withTrashed()->find($taskId);
        if(blank($task)){
            abort(back()->with('fail', __('messages.oop!'))); 
        }else{
            return $task;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $req, $subjectId, $taskId)
    {
        $task = $this->loadTask($taskId);
        $temp = $req->except(['_token']);
        $update = $task->update($temp);
        if($update){
            return redirect()->route('server.subject.task.index',[$subjectId])->with('msg', __('messages.update.success'));
        }else{
            return back()->with('msg', __('messages.update.fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subjectId, $taskId)
    {
        $task = $this->loadTask($taskId);
        $this->checkDataInTransaction($task,__FUNCTION__);
    }
    
    public function softDelete($subjectId, $taskId){
        $task = $this->loadTask($taskId);
        $this->checkDataInTransaction($task,__FUNCTION__);
    }
    public function restore($subjectId, $taskId){
        $task = $this->loadTask($taskId);
        $this->checkDataInTransaction($task,__FUNCTION__);
    }
    
}
