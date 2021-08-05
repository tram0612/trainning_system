<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserTask;

class UserObserver
{
    public function findRelatedUserCourse($userId){
        return UserCourse::withTrashed()->where('user_id',$userId)->get();
    }
    public function findRelatedUserTask($userId){
        return UserTask::withTrashed()->where('user_id',$userId)->get();
    }
    public function deleting(User $user)
    {
        $userCourses = $this->findRelatedUserCourse($user->id);
        $userTasks = $this->findRelatedUserTask($user->id);
        if ($user->isForceDeleting()) {
            foreach($userCourses as $userCourse){
                $userCourse->forceDelete();
            }
            foreach($userTasks as $userTask){
                $userTask->forceDelete();
            }
        }else{
            foreach($userCourses as $userCourse){
                $userCourse->delete();
            }
            foreach($userTasks as $userTask){
                $userTask->delete();
            }
        }
    }

    public function restored(User $user)
    {
        $userCourses = $this->findRelatedUserCourse($user->id);
        $userTasks = $this->findRelatedUserTask($user->id);
        foreach($userCourses as $userCourse){
            $userCourse->restore();
        }
        foreach($userTasks as $userTask){
            $userTask->restore();
        }
    }

}
