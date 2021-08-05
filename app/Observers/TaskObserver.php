<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\UserTask;

class TaskObserver
{
    
    /**
     * Handle the Task "deleted" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function findRelatedUserTask($taskId){
        return UserTask::withTrashed()->where('task_id', $taskId)->get();
    }
    public function deleting(Task $task)
    {
        $userTasks = $this->findRelatedUserTask($task->id);
        if ($task->isForceDeleting()) {
            foreach($userTasks as $userTask){
                $userTask->forceDelete();
            }
        }else{
            foreach($userTasks as $userTask){
                $userTask->delete();
            }
        }
    }

    /**
     * Handle the Task "restored" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function restored(Task $task)
    {
        $userTasks = $this->findRelatedUserTask($task->id);
        foreach($userTasks as $userTask){
            $userTask->restore();
        }
        
    }

}
