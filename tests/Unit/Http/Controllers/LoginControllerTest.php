<?php

namespace Tests\Unit\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function setUp() :void
    {
        parent::setUp();
        $this->user = User::factory()->create(['password'=>bcrypt('111111111')]);
        $this->traniee = User::factory()->create(['role'=>UserRole::Trainee]);
        $this->supervisor = User::factory()->create(['role'=>UserRole::Supervisor]);
        
    } 
    /** @test */
    public function a_guest_can_see_login_page()
    { 
        $response = $this->get('/signin')->assertOk();
    }
    /** @test */
   
    public function a_authenticated_user_can_see_login_page()
    { 
        $this->actingAs($this->user);
        $response = $this->get('/signin')->assertOk();
    }
    public function test_user_can_login_with_correct_credentials()
    {
        $response = $this->post('/signin', [
            'email' => $this->user->email,
            'password' => $this->user->password,
        ]);
        $this->actingAs($this->user);
        $this->assertAuthenticatedAs($this->user);
    }
    public function test_user_cannot_login_with_incorrect_password()
    {
        $response = $this->post('/signin', [
            'email' => $this->user->email,
            'password' => 'invalid-password',
        ]);
        $this->assertNotEquals('invalid-password',$this->user->password);
        $response->assertRedirect('/signin');
        $response->assertSessionHas(['msg'=>__('messages.login.fail')]);
        $this->assertGuest();
    }
    public function test_trainee_can_login_and_visit_home_page()
    {
        $response = $this->post('/signin', [
            'email' => $this->traniee->email,
            'password' => $this->traniee->password,
        ]);
        $response->assertRedirect('/');
    }
    public function test_superviser_can_login_and_visit_admin_page()
    {
        $response = $this->post('/signin', [
            'email' => $this->supervisor->email,
            'password' => $this->supervisor->password,
        ]);
        $response->assertRedirect('/server');
    }
    public function test_only_authenticated_user_can_logout()
    {
        $this->actingAs($this->user);
        $response = $this->get('/signout');
        $response->assertRedirect('/signin');
    }
}
