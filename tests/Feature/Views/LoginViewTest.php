<?php

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginViewTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_login_page_can_be_rendered()
    { 
        $this->withExceptionHandling();
        $view = $this->withViewErrors([
            'email' => ['Please provide a valid email.'],
            'password' => ['Please provide a valid password.'],
        ])->view('login');
        
        $view->assertSee('Please provide a valid email.');
        $view->assertSee('Please provide a valid password.');
        $view->assertDontSee('Course');
    }
    
}
