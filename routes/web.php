<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Server\UserController as UserController1;
use App\Http\Controllers\Server\CourseController as CourseController1;
use App\Http\Controllers\Server\CourseSubjectController as CourseSubjectController1;
use App\Http\Controllers\Server\UserCourseController as UserCourseController1;
use App\Http\Controllers\Server\SubjectController as SubjectController1;
use App\Http\Controllers\Server\TaskController as TaskController1;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\CourseController as CourseController2;
use App\Http\Controllers\Client\SubjectController as SubjectController2;
use App\Http\Controllers\Client\UserTaskController;
use App\Http\Controllers\Server\UserSubjectController;
use App\Http\Controllers\Server\UserTaskController as ServerUserTaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::pattern('user','([0-9]+)');
Route::pattern('course','([0-9]+)');
Route::pattern('subject','([0-9]+)');
Route::pattern('task','([0-9]+)');
Route::pattern('userSubject','([0-9]+)');


Route::get('/signin', [LoginController::class, 'getLogin'])->name('signin');
Route::post('/signin', [LoginController::class, 'postLogin'])->name('signin');
Route::get('/signout', [LoginController::class, 'logout'])->name('signout');
Route::prefix('server')->name('server.')->group(function(){
 	Route::middleware(['admin'])->group(function () {		
		Route::get('/', [CourseController1::class, 'dashboard'])->name('index');
		//route for user
		Route::resource('user', UserController1::class)->except(['index','edit']);
		Route::get('/trainee', [UserController1::class, 'trainee'])->name('user.trainee');
		Route::get('/supervisor', [UserController1::class, 'supervisor'])->name('user.supervisor');
		Route::name('user.')->group(function(){
			Route::post('/{user}/softDelete', [UserController1::class, 'softDelete'])->name('softDelete');
			Route::post('/{user}/restore', [UserController1::class, 'restore'])->name('restore');
		});
		//route for course
		Route::prefix('course')->name('course.')->group(function(){
			Route::get('/search', [CourseController1::class, 'search'])->name('search');
			Route::post('/{course}/finish', [CourseController1::class, 'finish'])->name('finish');
			Route::post('/{course}/softDelete', [CourseController1::class, 'softDelete'])->name('softDelete');
			Route::post('/{course}/restore', [CourseController1::class, 'restore'])->name('restore');
			Route::post('/status', [CourseSubjectController1::class, 'status'])->name('status');
			Route::post('/sortSubject', [CourseSubjectController1::class, 'sortSubject'])->name('sortSubject');
			Route::get('/{course}/detail', [CourseController1::class, 'detail'])->name('detail');
			Route::get('/{course}/traniee', [UserCourseController1::class, 'index'])->name('trainee');
			Route::get('/{course}/supervisor', [UserCourseController1::class, 'index'])->name('supervisor');
			Route::get('/{course}/user/{user}', [CourseController1::class, 'progress'])->name('progressUser');
			Route::name('user.')->group(function(){
				Route::post('/{course}/user/{user}/softDelete', [UserCourseController1::class, 'softDelete'])->name('softDelete');
				Route::post('/{course}/user/{user}/restore', [UserCourseController1::class, 'restore'])->name('restore');
				Route::get('{course}/subject/{subject}/user/{user}/task', [ServerUserTaskController::class, 'index'])->name('task');
			});
			Route::name('subject.')->group(function(){
				Route::post('/{course}/subject/{subject}/softDelete', [CourseSubjectController1::class, 'softDelete'])->name('softDelete');
				Route::post('/{course}/subject/{subject}/restore', [CourseSubjectController1::class, 'restore'])->name('restore');
			});
			
		});
		Route::prefix('userSubject')->name('userSubject.')->group(function(){
			Route::post('/{userSubject}/softDelete', [UserSubjectController::class, 'softDelete'])->name('softDelete');
			Route::post('/{userSubject}/restore', [UserSubjectController::class, 'restore'])->name('restore');
			Route::delete('/{userSubject}/restore', [UserSubjectController::class, 'destroy'])->name('destroy');
		});
		Route::resource('course.user', UserCourseController1::class)->only(['store','destroy']);
		Route::resource('course.subject', CourseSubjectController1::class);
		Route::resource('course', CourseController1::class)->except(['edit']);
		//route for subject
		Route::resource('subject', SubjectController1::class)->except(['edit']);
		Route::resource('subject.task', TaskController1::class)->except(['edit']);
		Route::prefix('subject')->name('subject.')->group(function(){
			Route::get('/search', [SubjectController1::class, 'search'])->name('search');
			Route::get('/{subject}/detail', [SubjectController1::class, 'detail'])->name('detail');
			Route::post('/sortTask', [TaskController1::class, 'sortTask'])->name('sortTask');
			Route::post('/{subject}/softDelete', [SubjectController1::class, 'softDelete'])->name('softDelete');
			Route::post('/{subject}/restore', [SubjectController1::class, 'restore'])->name('restore');
			
		});
		
	});
	
 
});

Route::middleware(['trainee'])->group(function () {
 	Route::get('/', [CourseController2::class, 'dashboard'])->name('index');
 	Route::resource('profile', ProfileController::class, ['parameters' => ['profile' => 'user']])->only(['show','update']);
 	Route::resource('course', CourseController2::class)->only(['index','show']);
 	Route::resource('course.subject', SubjectController2::class)->only(['show','edit']);
 	Route::resource('task', UserTaskController::class)->only(['update','store','edit','destroy']);
	Route::prefix('task')->name('task.')->group(function(){
		Route::post('/{task}/updateDuration', [UserTaskController::class, 'updateDuration'])->name('updateDuration');
	});
	
});


Route::fallback(function() {
    return __('views.hmm');
});

