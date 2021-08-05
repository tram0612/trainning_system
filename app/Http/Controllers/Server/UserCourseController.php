<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\URL;
use App\Enums\Status;
use App\Http\Requests\UserCourseRequest;
use App\Models\UserCourse;
use Illuminate\Support\Facades\DB;

class UserCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index($courseId)
    {
        $course = $this->loadCourseWithTrash($courseId);
        $url = URL::current();
        $role=0;
        if (strpos($url,'traniee') !== false) {
           $role = UserRole::Trainee;
        } else if(strpos($url,'supervisor') !== false) {
            $role = UserRole::Supervisor;
        }
        else{
            return back()->with('msg', __('messages.oop!'));
        }
        $userOfCourse=$course->user()->where('role',$role)->get();
        $users = User::where('role',$role)->get()->toArray();
        foreach($userOfCourse as $userCourse) {
            foreach ($users as $key=> $user){
                if($userCourse->id==$user['id']){
                    unset($users[$key]);
                    break;
                }
            }
        }
        return view('server.course.user.index',compact('course','users','userOfCourse'));
        
    }
    public function store(UserCourseRequest $req,$courseId)
    {  
        $course = $this->loadCourseWithTrash($courseId);
        $userIds = $req->input('userIds');
        foreach($userIds as $key=>$userId){
            $user = $this->loadUser($userId);
            DB::beginTransaction(); 
            try {
                UserCourse::create([
                    'user_id' => $userId,
                    'course_id' => $courseId,
                    'status' => Status::Start
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                abort(back()->with('fail', __('messages.add.fail')));
            }
        }
        return back()->with('msg', __('messages.add.success'));
    }
    public function loadUserCourse($courseId,$userId){
        $userCourse = UserCourse::withTrashed()->loadUserCourse($courseId,$userId)->first();
        if(blank($userCourse)){
            abort(redirect()->back()->with('fail', __('messages.oop!')));
        }else{
            return $userCourse;
        }

    }
    public function destroy($courseId,$userId)
    {   
        $userCourse = $this->loadUserCourse($courseId,$userId);
        $this->checkDataInTransaction($userCourse,__FUNCTION__);
    }
    public function softDelete($courseId,$userId){
        $userCourse = $this->loadUserCourse($courseId,$userId);
        $this->checkDataInTransaction($userCourse,__FUNCTION__);
    }
    public function restore($courseId,$userId){
        $userCourse = $this->loadUserCourse($courseId,$userId);
        $this->checkDataInTransaction($userCourse,__FUNCTION__);
    }
    
}
