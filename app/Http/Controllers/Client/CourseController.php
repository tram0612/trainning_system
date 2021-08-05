<?php

namespace App\Http\Controllers\Client;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Task;
use App\Enums\UserRole;
use App\Enums\Status;
use App\Models\UserCourse;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $user = $this->loadUser(Auth::id());
        $courses = UserCourse::getCourseWithoutTrash()->get();
        return view('client.course.index',compact('courses'));
    }
    public function loadUserCourse($id){
        $userCourse = Course::where('id',$id)
        ->whereHas('userCourse' , function ($query) {
            $query->withoutTrashed()->where('user_id',Auth::id());
        })->first();
        if(blank($userCourse)){
            abort(redirect()->back()->with('fail', __('messages.oop!')));
        } 
        else{
            return $userCourse; 
        }
    }

    public function dashboard()
    {
        $user = $this->loadUser(Auth::id());
        $unfinishedCourses = UserCourse::getCourseWithoutTrash()->unfinished()->get();
        $doneCourses = UserCourse::getCourseWithoutTrash()->done()->get();
        return view('client.index',compact('unfinishedCourses','doneCourses'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = $this->loadUserCourse($id);
        $members =  $course->user()->where('role',UserRole::Trainee)->get();
        $subjects = Course::loadSubjectforUserInCourse($id,Auth::id());
        $ids = array();
        foreach($course->subject as $subject){
            $ids[] = $subject->id;
        }
        $tasks = Task::getTaskForUser($ids);
        return view('client.course.detail',compact('course','members','subjects','tasks'));
    }
}
