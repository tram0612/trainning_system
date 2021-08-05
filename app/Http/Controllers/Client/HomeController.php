<?php

namespace App\Http\Controllers\Client;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Task;
use App\Models\User;
use App\Enums\Finish;
class HomeController extends Controller
{
    public function index(){
    	$user = $this->loadUser(Auth::id());
    	$courses = $user->course()->where('user_id',Auth::id())->paginate(4);
    	return view('client.index',compact('courses'));
    }
}
