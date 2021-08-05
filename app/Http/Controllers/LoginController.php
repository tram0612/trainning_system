<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

class LoginController extends Controller
{
	public function getLogin(){
		return view('login');
	}
    public function postLogin(LoginRequest $req){
    	if (Auth::attempt(
    		['email' => $req->email, 
    		'password' => $req->password])) {
            
    		if(Auth::user()->role==UserRole::Supervisor){
    			return redirect()->route('server.index');
    		}else{
				if(Auth::user()->role==UserRole::Trainee){
    				return redirect()->route('index');
				}
    		}
    		
		}
    	else{
    		return redirect()->back()->with('msg',__('messages.login.fail'));
    	}
    }
    public function logout(){
    	Auth::logout();
    	return redirect()->route('signin');
    }
    
}


