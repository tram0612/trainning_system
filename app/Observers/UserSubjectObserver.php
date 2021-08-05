<?php

namespace App\Observers;

use App\Enums\Status;
use App\Models\CourseSubject;
use App\Models\UserCourse;
use App\Models\UserSubject;

class UserSubjectObserver
{
    
    public function updated(UserSubject $userSubject)
    {
        $courseId = $userSubject->courseSubject->course_id;
        $userId = $userSubject->user_id;
        $courseSubjects = UserSubject::where('user_id',$userId)->whereHas('courseSubject', function ($query) use ($courseId){
            $query->where('course_id', $courseId);
        })->count();
        $userSubjects = UserSubject::where('user_id',$userId)->where('status',Status::Finish)->whereHas('courseSubject', function ($query) use ($courseId){
            $query->where('course_id', $courseId);
        })->count();
        if($courseSubjects == $userSubjects){
            UserCourse::where('user_id', $userId)
                ->where('course_id', $courseId)
                ->update(['status' => Status::Finish]);
        }else{
            UserCourse::where('user_id', $userId)
                ->where('course_id', $courseId)
                ->update(['status' => Status::Start]);
        }
    }

    
}
