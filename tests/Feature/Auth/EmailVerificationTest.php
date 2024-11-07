<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_login_with_correct_email_and_password()
    {
        // Create a user with known email and password
        $user = User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),  // Encrypted password
        ]);

        // Try to login with the correct email and password
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => 'admin123',  // Correct password
        ]);

        // Verify the login attempt was successful, redirect to the dashboard
        $response->assertStatus(302); 
        $response->assertRedirect(route('dashboard')); 
        $response->assertSessionHasNoErrors(); 
        $this->assertAuthenticatedAs($user); 
    }

    /** @test */
    public function test_user_can_access_dashboard_after_login()
    {
        $user = User::factory()->create();

        // Simulate login and access dashboard
        $response = $this->actingAs($user)->get('/dashboard');

        // Verify dashboard access after login
        $response->assertStatus(200);
    }

    /** @test */
    public function test_user_cannot_login_with_incorrect_email_and_password()
    {
        // Create a user with known email and password
        User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),  // Encrypted password
        ]);

        // Attempt to login with incorrect email and password
        $response = $this->post('/login', [
            'email' => 'user@gmail.com',
            'password' => 'admin345',
        ]);

        // Verify login fails and redirects back to login with errors
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email' => 'Email atau Password Salah']);
        $this->assertGuest();
    }

    /** @test */
    public function test_user_cannot_login_with_correct_email_and_wrong_password()
    {
        // Create a user with known email and password
        $user = User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);

        // Attempt to login with correct email and wrong password
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => 'admin345',
        ]);

        // Verify login fails and redirects back to login with errors
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email' => 'Email atau Password Salah']);
        $this->assertGuest();
    }

    /** @test */
    public function test_user_cannot_login_with_wrong_email_and_correct_password()
    {
        // Create a user with known email and password
        $user = User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);

        // Attempt to login with wrong email and correct password
        $response = $this->post('/login', [
            'email' => 'user@gmail.com',
            'password' => 'admin123',
        ]);

        // Verify login fails and redirects back to login with errors
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email' => 'Email atau Password Salah']);
        $this->assertGuest();
    }

    /** @test */
    public function test_user_cannot_login_with_empty_email_and_password()
    {
        // Attempt to login with empty email and password
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        // Verify login fails, redirects back to login, and has errors for both fields
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors([
            'email' => 'Email kosong',
            'password' => 'Password kosong'
        ]);
        $this->assertGuest();
    }
}
