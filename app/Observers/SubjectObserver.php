<?php

namespace App\Observers;

use App\Models\CourseSubject;
use App\Models\Subject;
use App\Models\Task;

class SubjectObserver
{
    /**
     * Handle the Subject "deleted" event.
     *
     * @param  \App\Models\Subject  $subject
     * @return void
     */
    public function findRelatedCourseSubject($subjectId){
        return CourseSubject::withTrashed()->where('subject_id',$subjectId)->get();
    }
    public function findRelatedTask($subjectId){
        return Task::withTrashed()->where('subject_id',$subjectId)->get();
    }
    public function deleting(Subject $subject)
    {
        $tasks = $this->findRelatedTask($subject->id);
        $courseSubjects = $this->findRelatedCourseSubject($subject->id);
        if ($subject->isForceDeleting()) {
            
            foreach($courseSubjects as $courseSubject){
                $courseSubject->forceDelete();
            }
            foreach($tasks as $task){
                $task->forceDelete();
            }
        }else{
            foreach($courseSubjects as $courseSubject){
                $courseSubject->delete();
            }
            foreach($tasks as $task){
                $task->delete();
            }
        }
    }

    /**
     * Handle the Subject "restored" event.
     *
     * @param  \App\Models\Subject  $subject
     * @return void
     */
    public function restored(Subject $subject)
    {
        $tasks = $this->findRelatedTask($subject->id);
        $courseSubjects = $this->findRelatedCourseSubject($subject->id);
        foreach($courseSubjects as $courseSubject){
            $courseSubject->restore();
        }
        foreach($tasks as $task){
            $task->restore();
        }
    }
}
