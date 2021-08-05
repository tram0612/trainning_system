<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'subject';
    protected $primaryKey='id';
   	public $timestamps = true;
    protected $fillable = [
        'name',
        'img',
        'finish',
        'detail'
    ];
    public function course()
    {
        return $this->belongstoMany(Course::class, 'course_subject')->withPivot('status','started_at','position') ->orderBy('pivot_position');
    }
    public function courseSubject()
    {
        return $this->hasMany(CourseSubject::class,'subject_id');
    }
    public function userSubject()
    {
        return $this->hasMany(UserSubject::class);
    }
    public function task()
    {
        return $this->hasMany(Task::class,'subject_id')->orderBy('position');
    }
    public function userTask()
    {
        return $this->hasManyThrough(UserTask::class,Task::class,'subject_id','task_id');
    }
    
    
}
