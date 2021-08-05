<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function loadUser($id){

        $user = User::find($id);
        if(blank($user)){
            abort(redirect()->back()->with('fail', __('messages.oop!')));
        } 
        else{
            return $user; 
        }
    }
    public function loadCourse($id){

        $course = Course::find($id);
        if(blank($course)){
            abort(redirect()->back()->with('fail', __('messages.oop!')));
        } 
        else{
            return $course; 
        }
    }
    public function loadSubject($id){

        $subject = Subject::find($id);
        if(blank($subject)){
            abort(redirect()->back()->with('fail', __('messages.oop!')));
        } 
        else{
            return $subject; 
        }
    }
    public function loadSubjectWithTrash($id){

        $subject = Subject::withTrashed()->find($id);
        if(blank($subject)){
            abort(redirect()->back()->with('fail', __('messages.oop!')));
        } 
        else{
            return $subject; 
        }
    }
    public function loadCourseWithTrash($id){

        $course = Course::withTrashed()->find($id);
        if(blank($course)){
            abort(redirect()->back()->with('fail', __('messages.oop!')));
        } 
        else{
            return $course; 
        }
    }
    public function loadUserWithTrash($id){

        $user = User::withTrashed()->find($id);
        if(blank($user)){
            abort(redirect()->back()->with('fail', __('messages.oop!')));
        } 
        else{
            return $user; 
        }
    }
    public function checkDataInTransaction($object,$action)
    {
        $result = DB::transaction(function () use($object,$action){ 
            switch ($action) {
                case 'destroy':
                {
                    return $object->forceDelete();
                }
                case 'softDelete':
                {
                    return $object->delete();
                }
                case 'restore':
                {
                    return $object->restore();
                }
                default: return false;
            };
        });
        if($result){
            abort(back()->with('msg', __('messages.'.$action.'.success')));
        }else{
            abort(back()->with('fail', __('messages.'.$action.'.success')));
        };
    }
}
