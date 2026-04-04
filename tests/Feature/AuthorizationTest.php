<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user
        $this->adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'is_active' => true,
            'is_admin' => true,
        ]);

        // Create regular user
        $this->regularUser = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
            'is_active' => true,
            'is_admin' => false,
        ]);
    }

    /**
     * Test admin user can access admin dashboard
     */
    public function test_admin_user_can_access_admin_dashboard()
    {
        $response = $this->actingAs($this->adminUser)->get('/admin');

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    /**
     * Test regular user cannot access admin dashboard
     */
    public function test_regular_user_cannot_access_admin_dashboard()
    {
        $response = $this->actingAs($this->regularUser)->get('/admin');

        $response->assertRedirect('/login');
        $response->assertSessionHas('error');
    }

    /**
     * Test non-authenticated user redirects to login
     */
    public function test_unauthenticated_user_redirected_to_login_for_admin()
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    /**
     * Test admin can access news management
     */
    public function test_admin_can_access_news_management()
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/news');

        $response->assertStatus(200);
    }

    /**
     * Test regular user cannot access news management
     */
    public function test_regular_user_cannot_access_news_management()
    {
        $response = $this->actingAs($this->regularUser)->get('/admin/news');

        $response->assertRedirect('/login');
    }

    /**
     * Test is_admin flag is checked
     */
    public function test_user_without_admin_flag_cannot_access_admin()
    {
        // Create user without admin flag
        $user = User::create([
            'name' => 'Not Admin',
            'email' => 'notadmin@example.com',
            'password' => bcrypt('password123'),
            'is_active' => true,
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertRedirect('/login');
        $response->assertSessionHas('error');
    }
}
