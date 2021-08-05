<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'task';
    protected $primaryKey='id';
   	public $timestamps = true;
    protected $fillable = [
        'name',
        'subject_id',
        'detail',
        'position'
    ];
    public function userTask()
    {
        return $this->hasMany(UserTask::class,'task_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id');
    }
    public function scopeGetTaskForUser($query,$ids)
    { 
        return $query->with(['userTask' => function ($query) {
            $query->where('user_id', Auth::id())->where('status',Status::Finish);
        }])->whereIn('subject_id',$ids)->get();
    }
    
}
