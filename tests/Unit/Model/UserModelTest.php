<?php

namespace Tests\Unit\Model;

use App\Models\Course;
use App\Models\CourseSubject;
use App\Models\Subject;
use App\Models\Task;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserSubject;
use App\Models\UserTask;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserModelTest extends TestCase
{
    use RefreshDatabase,WithFaker;
    
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function setUp() :void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->course = Course::factory()->create();
        $this->subject = Subject::factory()->create();
        
    } 
    /** @test */
    public function users_database_has_expected_columns()
    { 
        $this->assertTrue( 
          Schema::hasColumns('users', [
            'id','name', 'email', 'password','avatar','role',
            'created_at','deleted_at','updated_at'
        ]), 1);
    }
    
     /** @test */
    public function a_user_belongs_to_many_course()
    { 
        $course = Course::factory()->create();
        $this->assertCount(0, $this->user->course);
        $this->user->course()->attach($course->id,['status'=> 0]);
        $this->assertCount(1,$this->user->fresh()->course);
        $this->assertTrue($this->user->course()->first()->is($course));
    }
    /** @test */
    public function a_user_has_many_userCourse()
    {
        $userCourse = UserCourse::factory()->create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id
        ]);
        // Method 1: A userCourse exists in a this->user's userCourse collections.
        $this->assertTrue($this->user->userCourse->contains($userCourse));
        
        // Method 2: Count that a this->user userCourses collection exists.
        $this->assertEquals(1, $this->user->userCourse->count());

        // Method 3: userCourses are related to this->users and is a collection instance.
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->userCourse);
    }
    public function a_user_has_many_userSubject()
    { 
        $courseSubject = CourseSubject::factory()->create([
            'course_id' => $this->course->id,
            'subject_id' => $this->subject->id
        ]);
        $userSubject = UserSubject::factory()->create([
            'user_id' => $this->user->id,
            'cs_id' => $courseSubject->id,
            
        ]);
        $this->assertTrue($this->user->userSubject->contains($userSubject));
        $this->assertEquals(1, $this->user->userSubject->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->userSubject);
    }
    public function a_user_has_many_userTask()
    { 
        $task = Task::factory()->create([
            'subject_id'=>$this->subject->id,
        ]);
        $userTask = UserTask::factory()->create([
            'user_id' => $this->user->id,
            'task_id' => $task->id
        ]);
        $this->assertTrue($this->user->userTask->contains($userTask));
        $this->assertEquals(1, $this->user->userTask->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->userTask);
    }
}
