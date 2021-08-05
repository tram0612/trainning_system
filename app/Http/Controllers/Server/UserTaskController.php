<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;


class UserTaskController extends Controller
{
    public function index($courseId,$subjectId,$userId){
        $course = $this->loadCourseWithTrash($courseId);
        $user = $this->loadUserWithTrash($userId);
        $subject =$this->loadSubjectWithTrash($subjectId);
        $tasks = $subject->task()->with(['userTask' => function ($query) use($userId) {
            $query->where('user_id', $userId);
        }])->get();
        
        return view('server.course.user.task',compact('tasks','course','user','subject'));
    }
}
