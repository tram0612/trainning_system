<?php

namespace App\Observers;

use App\Enums\Status;
use App\Models\CourseSubject;
use App\Models\UserSubject;
use App\Models\UserTask;
use Illuminate\Support\Facades\DB;

class CourseSubjectObserver
{
    /**
     * Handle the CourseSubject "created" event.
     *
     * @param  \App\Models\CourseSubject  $courseSubject
     * @return void
     */
    public function created(CourseSubject $courseSubject)
    { 
        $userIds = DB::table('user_course')
            ->select('user_id')
            ->where('course_id',$courseSubject->course_id)
            ->get();
        foreach($userIds as $user){
            UserSubject::create([
                'user_id' => $user->user_id,
                'cs_id' => CourseSubject::latest()->first()->id,
                'status' => Status::Start,
            ]); 
        }
        
    }
    
    public function findRelateddUserTask($courseId,$subjectId){
        return UserTask::withTrashed()->whereHas('task.subject.courseSubject', function ($query) use ($courseId,$subjectId){
            $query->where('course_id', $courseId)->where('subject_id', $subjectId);
        })
        ->get();
    }
    public function findRelateddUserSubject($courseId,$subjectId){
        return UserSubject::withTrashed()->whereHas('courseSubject', function ($query) use ($courseId,$subjectId){
            $query->where('course_id', $courseId)->where('subject_id', $subjectId);
        })
        ->get();
    }
    public function deleting(CourseSubject $courseSubject)
    {
        $courseId = $courseSubject->course_id;
        $subjectId = $courseSubject->subject_id;
        $userTasks = $this->findRelateddUserTask($courseId,$subjectId);
        $usersubjects = $this->findRelateddUserSubject($courseId,$subjectId);
       
        if ($courseSubject->isForceDeleting()) {
            foreach($usersubjects as $userSubject){
                $userSubject->forceDelete();
            }
            foreach($userTasks as $userTask){
                $userTask->forceDelete();
            }
        }
        else{
            foreach($usersubjects as $userSubject){
                $userSubject->delete();
            }
            foreach($userTasks as $userTask){
                $userTask->delete();
            }
        }
    }
    
    public function restored(CourseSubject $courseSubject)
    {
        $courseId = $courseSubject->course_id;
        $subjectId = $courseSubject->subject_id;
        $userTasks =$this->findRelateddUserTask($courseId,$subjectId);
        $usersubjects = $this->findRelateddUserSubject($courseId,$subjectId);
        foreach($usersubjects as $userSubject){
            $userSubject->restore();
        }
        foreach($userTasks as $userTask){
            $userTask->restore();
        }
    }

}
