<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserTask;
use App\Enums\Status;
use Illuminate\Support\Facades\Auth;
class UserTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loadTask($id){
        $task = UserTask::find($id);
        if(blank($task)||$task->user_id!=Auth::id()){
            abort(response()->json(['success' => false])) ;
        }
        else{
            return $task;
        }
    }
    
    public function store(Request $request)
    {
        $userTask = UserTask::create([
            'user_id' => Auth::id(),
            'task_id' => $request->task_id,
            'comment' => $request->comment,
            'duration' => $request->duration,
            'status'  => Status::Start,
        ]);
        if($userTask){
           $html = view('client.course.subject.addTask')->with(compact('userTask'))->render(); 
            return response()->json(['success' => true, 'html' => $html]); 
        }
        else{
             return response()->json(['success' => false]);
        }
    }
    public function updateDuration(Request $request, $id)
    {
        $task = $this->loadTask($id);
        $temp = $request->only(['duration']);
        $update = $task->update($temp);
        if($update){
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = $this->loadTask($id);
        if($task->status==Status::Start){
            $task->status = Status::Finish;
        }
        else{
           $task->status = Status::Start; 
        }
        $task->save();
        return response()->json(['success' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = $this->loadTask($id);
        $temp = $request->only(['comment']);
        $update = $task->update($temp);
        if($update){
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
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
        $task = $this->loadTask($id);
        $task->forceDelete();
        return response()->json(['success' => true]);
    }
}
