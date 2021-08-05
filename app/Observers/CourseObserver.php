<?php

namespace App\Observers;

use App\Models\Course;
use App\Models\CourseSubject;
use App\Models\UserCourse;

class CourseObserver
{
    public function findRelatedCourseSubject($courseId)
    {
        return CourseSubject::withTrashed()->where('course_id',$courseId)->get();
    }
    public function findRelatedUserCourse($courseId)
    {
        return UserCourse::withTrashed()->where('course_id',$courseId)->get();
    }
    public function deleting(Course $course)
    {
        $courseSubjects = $this->findRelatedCourseSubject($course->id);
        $userCourses = $this->findRelatedUserCourse($course->id);
        if ($course->isForceDeleting()) {
            foreach($courseSubjects as $courseSubject){
                $courseSubject->forceDelete();
            }
            foreach($userCourses as $userCourse){
                $userCourse->forceDelete();
            }
        }
        else{
            foreach($courseSubjects as $courseSubject){
                $courseSubject->delete();
            }
            foreach($userCourses as $userCourse){
                $userCourse->delete();
            }
        }
    }

    /**
     * Handle the Course "restored" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function restored(Course $course)
    {
        $courseSubjects = $this->findRelatedCourseSubject($course->id);
        $userCourses = $this->findRelatedUserCourse($course->id);
        foreach($courseSubjects as $courseSubject){
            $courseSubject->restore();
        }
        foreach($userCourses as $userCourse){
            $userCourse->restore();
        }
    }
}
