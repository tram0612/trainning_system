<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Models\UserSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSubjectController extends Controller
{
    public function loadUserSubjectWithTrash($id){
        $userSubject = UserSubject::withTrashed()->find($id);
        if(blank($userSubject)){
            abort(redirect()->back()->with('fail', __('messages.oop!')));
        } 
        else{
            return $userSubject; 
        }
    }
    public function destroy($id)
    {   
        $userSubject = $this->loadUserSubjectWithTrash($id);
        $this->checkDataInTransaction($userSubject,__FUNCTION__);
    }
}
