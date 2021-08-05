<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
class UserCourse extends Pivot
{
    use HasFactory,SoftDeletes;
    protected $table = 'user_course';
    protected $primaryKey='id';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'course_id',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(Task::class,'user_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
    public function userSubject()
    {
        return $this->hasMany(UserSubject::class,'user_id','user_id');
    }
    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    
    public function scopeWhereCourseId($query,$courseId)
    {
        return $query->where('course_id',$courseId);
    }
    public function scopeLoadUserCourse($query,$courseId,$userId){
        return $query->where('course_id',$courseId)->where('user_id',$userId);
    }
    public function scopeGetCourseWithoutTrash($query){
        return $query->whereHas('course' , function (Builder $query){
            $query->withoutTrashed();
        })->where('user_id',Auth::id());
    }
    public function scopeUnfinished($query){
        return $query->where('status',Status::Start);
    } 
    public function scopeDone($query){
        return $query->where('status',Status::Finish);
    }  
   
}
