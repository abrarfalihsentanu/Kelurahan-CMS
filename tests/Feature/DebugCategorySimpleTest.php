<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\NewsCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DebugCategorySimpleTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'is_active' => true,
        ]);
    }

    public function test_post_news_category_creates_record(): void
    {
        $data = [
            'name' => 'Debug Test Category',
            'slug' => 'debug-test-category',
            'icon' => 'fa fa-test',
            'description' => 'Debug Test Description',
            'order' => 1,
            'is_active' => true,
        ];

        $response = $this->actingAs($this->user)->post('/admin/news-categories', $data);

        $this->assertTrue(NewsCategory::where('name', 'Debug Test Category')->exists());
    }
}
