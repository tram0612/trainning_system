<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserSubject;
use App\Models\CourseSubject;


class Course extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'course';
    protected $primaryKey='id';
   	public $timestamps = true;
    protected $fillable = [
        'name',
        'img',
        'finish',
        'detail',
        'instruction'
    ];

    public function subject()
    {
        return $this->belongstoMany(Subject::class, 'course_subject', 'course_id', 'subject_id')->withPivot('status','started_at','position','deleted_at') ->orderBy('pivot_position');
    }
    public function user()
    {
        return $this->belongstoMany(User::class, 'user_course','course_id','user_id')->withPivot('status','deleted_at');
    }
    public function userCourse()
    {
        return $this->hasMany(UserCourse::class,'course_id');
    }
    public function userSubject()
    {
        return $this->hasManyThrough(
            UserSubject::class,
            CourseSubject::class,
            'course_id', // khóa ngoại của bảng trung gian
            'cs_id', // khóa ngoại của bảng mà chúng ta muốn gọi tới
            'id', //trường mà chúng ta muốn liên kết ở bảng đang sử dụng
            'id' // trường mà chúng ta muốn liên kết ở bảng trung gian.
        );
    }
    public function courseSubject()
    {
        return $this->hasMany(CourseSubject::class,'course_id');
    }
    
    public static function index(){
        return Course::select(['id', 'name','img','finish'])->paginate(10);
    }
    public function scopeLoadSubjectforUserInCourse($query,$courseId,$userId){
        return $query->withTrashed()->with(['userSubject' => function ($query) use($userId) {
            $query->where('user_id', $userId)->with('courseSubject.subject')->withTrashed()->orderBy('position');
        }])->find($courseId)->toArray();
    }
    
}
