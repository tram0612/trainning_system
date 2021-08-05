<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\CourseSubject;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Task;
use App\Models\UserCourse;
use App\Models\UserSubject;
use App\Observers\CourseObserver;
use App\Observers\CourseSubjectObserver;
use App\Observers\SubjectObserver;
use App\Observers\TaskObserver;
use App\Observers\UserCourseObserver;
use App\Observers\UserSubjectObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Course::observe(CourseObserver::class);
        UserCourse::observe(UserCourseObserver::class);
        CourseSubject::observe(CourseSubjectObserver::class);
        Task::observe(TaskObserver::class);
        Subject::observe(SubjectObserver::class);
        UserSubject::observe(UserSubjectObserver::class);
    }
}
