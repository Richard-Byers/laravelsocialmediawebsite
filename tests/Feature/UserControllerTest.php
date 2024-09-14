<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_success()
    {
        $response = $this->post('/register', [
            'username' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'You have successfully registered an account.');
        $this->assertAuthenticated();
    }

    public function test_register_validation_error()
    {
        $response = $this->post('/register', [
            'username' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'different'
        ]);

        $response->assertSessionHasErrors(['username', 'email', 'password']);
    }

    public function test_register_duplicate_username_email()
    {
        User::factory()->create(['username' => 'testuser', 'email' => 'testuser@example.com']);

        $response = $this->post('/register', [
            'username' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertSessionHasErrors(['username', 'email']);
    }

    public function test_login_success()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password')
        ]);

        $response = $this->post('/login', [
            'loginusername' => 'testuser',
            'loginpassword' => 'password'
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'You have successfully logged in.');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_failure()
    {
        $response = $this->post('/login', [
            'loginusername' => 'wronguser',
            'loginpassword' => 'wrongpassword'
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('failure', 'Wrong username and/or password entered.');
        $this->assertGuest();
    }

    public function test_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'You have successfully logged out.');
        $this->assertGuest();
    }

    public function test_show_correct_home_page_authenticated()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertViewIs('homepage-feed');
    }

    public function test_show_correct_home_page_unauthenticated()
    {
        $response = $this->get('/');

        $response->assertViewIs('homepage');
    }
}
