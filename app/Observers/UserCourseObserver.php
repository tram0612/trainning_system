<?php

namespace App\Observers;

use App\Enums\Status;
use App\Models\CourseSubject;
use App\Models\UserCourse;
use App\Models\UserSubject;
use Illuminate\Support\Facades\URL;

class UserCourseObserver
{
    /**
     * Handle the UserCourse "created" event.
     *
     * @param  \App\Models\UserCourse  $userCourse
     * @return void
     */
    public function created(UserCourse $userCourse)
    {
        $ids = CourseSubject::withTrashed()->selectIdWhereCourseId($userCourse->course_id)->get();
        
        foreach($ids as $id){
            UserSubject::create([
                'user_id' => $userCourse->user_id,
                'cs_id' => $id->id,
                'status' => Status::Start,
            ]); 
        }
    }
    public function findRelateddUserSubject($courseId,$userId){
        return UserSubject::withTrashed()->where('user_id',$userId)->whereHas('courseSubject' , function ($query) use ($courseId){
            $query->where('course_id',$courseId);
        })->get();
    }
    public function deleting(UserCourse $userCourse)
    {
        $courseId = $userCourse->course_id;
        $userId = $userCourse->user_id;
        $userSubjects = UserSubject::findRelateddUserSubject($courseId,$userId);
       
        if ($userCourse->isForceDeleting()) {
            foreach($userSubjects as $userSubject){
                $userSubject->forceDelete();
            }
        }else{
            foreach($userSubjects as $userSubject){
                $userSubject->delete();
            }
        }
    }
    
    /**
     * Handle the UserCourse "restored" event.
     *
     * @param  \App\Models\UserCourse  $userCourse
     * @return void
     */
    public function restored(UserCourse $userCourse)
    {
        $courseId = $userCourse->course_id;
        $userId = $userCourse->user_id;
        $userSubjects = $this->findRelateddUserSubject($courseId,$userId);
        foreach($userSubjects as $userSubject){
            $userSubject->restore();
        }
    }
}
