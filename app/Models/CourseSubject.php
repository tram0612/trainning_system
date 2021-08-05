<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseSubject extends Model
{
    use SoftDeletes;
    protected $table = 'course_subject';
    protected $primaryKey='id';
    protected $fillable = [
        'course_id',
        'subject_id',
        'status',
        'started_at',
        'days',
        'position',
    ];
    public $timestamps = true;
    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id');
    }
    public function user()
    {
        return $this->belongstoMany(User::class, 'user_subject')->withPivot('status','started_at','position') ->orderBy('pivot_position');
    }
    public function userSubject()
    {
        return $this->hasMany(UserSubject::class,'cs_id');
    }
    public static function updateDate($req, $courseId,$subjectId){
        $subject = CourseSubject::where('course_id',$courseId)->where('subject_id',$subjectId)->first();
        if(blank($subject)){
            return back()->with('msg', __('messages.oop!'));
        }
        $date = date('Y-m-d', strtotime($req->started_at));
        $subject->started_at = $date;
        $subject->save();
        return $subject;
    }
    public static function updateStatus($courseId,$subjectId){
        $subject = CourseSubject::where('course_id',$courseId)->where('subject_id',$subjectId)->update(['status'=>Status::Finish]);
        return $subject;
    }
    public static function sortSubject($req){
        $arr = explode(',', $req->ids);
        for($i=0; $i<count($arr); $i++){
            CourseSubject::where('course_id',$req->courseId)
                        ->where('subject_id',$arr[$i])
                        ->update(['position'=>$i]);
        }
    }
    public function scopeSelectIdWhereCourseId($query,$courseId)
    {
        return $query->select('id')->where('course_id',$courseId);
    }
    
}
