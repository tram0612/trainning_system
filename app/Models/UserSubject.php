<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubject extends Model
{
    use SoftDeletes;
    protected $table = 'user_subject';
    protected $primaryKey='id';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'cs_id',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(Task::class,'user_id');
    }
    
    public function courseSubject()
    {
        return $this->belongsTo(CourseSubject::class,'cs_id');
    }
    public function scopeFindRelateddUserSubject($query,$courseId,$userId)
    {
        return $query->withTrashed()->where('user_id',$userId)->whereHas('courseSubject' , function ($query) use ($courseId){
            $query->where('course_id',$courseId);
        })->get();
    }
    
}
