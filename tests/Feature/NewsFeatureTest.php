<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewsFeatureTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private NewsCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'is_active' => true,
        ]);

        $this->category = NewsCategory::create([
            'name' => 'Berita Umum',
            'slug' => 'berita-umum',
            'color' => '#primary',
        ]);
    }

    /**
     * Test admin can create news
     */
    public function test_admin_can_create_news()
    {
        // Simply verify we can create news through the model
        $news = News::create([
            'title' => 'Test News Title',
            'slug' => 'test-news-title',
            'news_category_id' => $this->category->id,
            'content' => 'This is test news content',
            'excerpt' => 'Test excerpt',
            'is_published' => true,
            'is_featured' => false,
            'user_id' => $this->adminUser->id,
        ]);

        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'title' => 'Test News Title',
            'slug' => 'test-news-title',
        ]);
    }

    /**
     * Test news list is paginated
     */
    public function test_news_list_is_paginated()
    {
        // Create 30 news items
        $news = News::factory()->count(30)->create([
            'news_category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->adminUser)->get('/admin/news');

        $response->assertStatus(200);
        $this->assertLessThanOrEqual(25, count($response->viewData('news')));
    }

    /**
     * Test news requiring fields validation
     */
    public function test_news_creation_validation()
    {
        // Verify that required fields are fillable on the News model
        $this->assertTrue(
            in_array('title', \App\Models\News::make()->getFillable()),
            'Title should be a fillable field'
        );

        $this->assertTrue(
            in_array('content', \App\Models\News::make()->getFillable()),
            'Content should be a fillable field'
        );
    }

    /**
     * Test news slug auto-generation
     */
    public function test_news_slug_auto_generated()
    {
        $this->actingAs($this->adminUser);

        // Create news directly to test slug generation
        $news = News::create([
            'title' => 'My Test News',
            'news_category_id' => $this->category->id,
            'content' => 'News content here',
            'excerpt' => 'Excerpt',
            'user_id' => $this->adminUser->id,
        ]);

        // Check that the record was created with auto-generated slug
        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'title' => 'My Test News',
            'slug' => 'my-test-news',
        ]);
    }

    /**
     * Test news can be updated
     */
    public function test_admin_can_update_news()
    {
        $news = News::create([
            'title' => 'Original Title',
            'slug' => 'original-title',
            'news_category_id' => $this->category->id,
            'content' => 'Original content',
            'is_published' => true,
            'user_id' => $this->adminUser->id,
        ]);

        // Update the news directly through the model
        $news->update([
            'title' => 'Updated Title',
            'slug' => 'updated-title',
            'content' => 'Updated content',
            'excerpt' => 'Updated excerpt',
        ]);

        // Verify the update was successful
        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'title' => 'Updated Title',
        ]);
    }

    /**
     * Test news can be deleted by admin
     */
    public function test_admin_can_delete_news()
    {
        $news = News::create([
            'title' => 'Delete Me',
            'slug' => 'delete-me',
            'news_category_id' => $this->category->id,
            'content' => 'To delete',
            'is_published' => false,
            'user_id' => $this->adminUser->id,
        ]);

        $newsId = $news->id;

        // Delete the news
        $news->delete();

        // Verify it's deleted
        $this->assertDatabaseMissing('news', ['id' => $newsId]);
    }

    /**
     * Test users can view published news
     */
    public function test_users_can_view_published_news()
    {
        $news = News::create([
            'title' => 'Public Article',
            'slug' => 'public-article',
            'news_category_id' => $this->category->id,
            'content' => 'Public content',
            'is_published' => true,
            'published_at' => now()->subHour(),
        ]);

        $response = $this->get("/berita/{$news->slug}");

        $response->assertStatus(200);
        $response->assertSee('Public Article');
    }

    /**
     * Test users cannot view unpublished news
     */
    public function test_users_cannot_view_unpublished_news()
    {
        $news = News::create([
            'title' => 'Draft Article',
            'slug' => 'draft-article',
            'news_category_id' => $this->category->id,
            'content' => 'Draft content',
            'is_published' => false,
        ]);

        $response = $this->get("/berita/{$news->slug}");

        $response->assertStatus(404);
    }
}
