<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user can login with correct credentials
     */
    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'is_active' => true,
            'is_admin' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test user cannot login with incorrect password
     */
    public function test_user_cannot_login_with_incorrect_password()
    {
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'is_active' => true,
            'is_admin' => false,
        ]);

        // Visit login page first to set proper referer
        $this->get('/login');

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Test user can logout
     */
    public function test_user_can_logout()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'is_active' => true,
            'is_admin' => false,
        ]);

        $this->actingAs($user);
        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Test inactive user cannot access admin
     */
    public function test_inactive_user_cannot_login()
    {
        $user = User::create([
            'name' => 'Inactive User',
            'email' => 'inactive@example.com',
            'password' => bcrypt('password123'),
            'is_active' => false,
            'is_admin' => true,
        ]);

        // Visit login page first  
        $this->get('/login');

        $response = $this->post('/login', [
            'email' => 'inactive@example.com',
            'password' => 'password123',
        ]);

        // Should be redirected back with errors
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
