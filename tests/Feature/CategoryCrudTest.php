<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\NewsCategory;
use App\Models\ServiceCategory;
use App\Models\ComplaintCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryCrudTest extends TestCase
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

    // News Category Tests
    public function test_news_categories_index_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/news-categories');
        $response->assertStatus(200);
        $response->assertViewIs('admin.news-categories.index');
    }

    public function test_news_categories_create_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/news-categories/create');
        $response->assertStatus(200);
        $response->assertViewIs('admin.news-categories.create');
    }

    public function test_create_news_category(): void
    {
        $data = [
            'name' => 'Test Category',
            'slug' => 'test-category',
            'icon' => 'fa fa-test',
            'description' => 'Test Description',
            'order' => 1,
            'is_active' => true,
        ];

        $response = $this->actingAs($this->user)->post('/admin/news-categories', $data);
        $response->assertRedirect('/admin/news-categories');

        $this->assertDatabaseHas('news_categories', ['name' => 'Test Category']);
    }

    public function test_edit_news_category_page_loads(): void
    {
        $category = NewsCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'icon' => 'fa fa-test',
            'description' => 'Test Description',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->get("/admin/news-categories/{$category->id}/edit");
        $response->assertStatus(200);
        $response->assertViewIs('admin.news-categories.edit');
    }

    public function test_update_news_category(): void
    {
        $category = NewsCategory::create([
            'name' => 'Original Name',
            'slug' => 'original-name',
            'icon' => 'fa fa-original',
            'description' => 'Original Description',
            'order' => 1,
            'is_active' => true,
        ]);

        $data = [
            'name' => 'Updated Name',
            'slug' => 'updated-name',
            'icon' => 'fa fa-updated',
            'description' => 'Updated Description',
            'order' => 2,
            'is_active' => false,
        ];

        $response = $this->actingAs($this->user)->put("/admin/news-categories/{$category->id}", $data);
        $response->assertRedirect('/admin/news-categories');

        $this->assertDatabaseHas('news_categories', ['id' => $category->id, 'name' => 'Updated Name']);
    }

    public function test_delete_news_category(): void
    {
        $category = NewsCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'icon' => 'fa fa-test',
            'description' => 'Test Description',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->delete("/admin/news-categories/{$category->id}");
        $response->assertRedirect('/admin/news-categories');

        $this->assertDatabaseMissing('news_categories', ['id' => $category->id]);
    }

    // Service Category Tests
    public function test_service_categories_index_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/service-categories');
        $response->assertStatus(200);
        $response->assertViewIs('admin.service-categories.index');
    }

    public function test_service_categories_create_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/service-categories/create');
        $response->assertStatus(200);
        $response->assertViewIs('admin.service-categories.create');
    }

    public function test_create_service_category(): void
    {
        $data = [
            'name' => 'Service Test',
            'slug' => 'service-test',
            'icon' => 'fa fa-service',
            'description' => 'Service Description',
            'order' => 1,
            'is_active' => true,
        ];

        $response = $this->actingAs($this->user)->post('/admin/service-categories', $data);
        $response->assertRedirect('/admin/service-categories');

        $this->assertDatabaseHas('service_categories', ['name' => 'Service Test']);
    }

    public function test_edit_service_category_page_loads(): void
    {
        $category = ServiceCategory::create([
            'name' => 'Service Category',
            'slug' => 'service-category',
            'icon' => 'fa fa-service',
            'description' => 'Service Description',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->get("/admin/service-categories/{$category->id}/edit");
        $response->assertStatus(200);
        $response->assertViewIs('admin.service-categories.edit');
    }

    public function test_update_service_category(): void
    {
        $category = ServiceCategory::create([
            'name' => 'Original Service',
            'slug' => 'original-service',
            'icon' => 'fa fa-original',
            'description' => 'Original Description',
            'order' => 1,
            'is_active' => true,
        ]);

        $data = [
            'name' => 'Updated Service',
            'slug' => 'updated-service',
            'icon' => 'fa fa-updated',
            'description' => 'Updated Description',
            'order' => 2,
            'is_active' => false,
        ];

        $response = $this->actingAs($this->user)->put("/admin/service-categories/{$category->id}", $data);
        $response->assertRedirect('/admin/service-categories');

        $this->assertDatabaseHas('service_categories', ['id' => $category->id, 'name' => 'Updated Service']);
    }

    public function test_delete_service_category(): void
    {
        $category = ServiceCategory::create([
            'name' => 'Service Category',
            'slug' => 'service-category',
            'icon' => 'fa fa-service',
            'description' => 'Service Description',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->delete("/admin/service-categories/{$category->id}");
        $response->assertRedirect('/admin/service-categories');

        $this->assertDatabaseMissing('service_categories', ['id' => $category->id]);
    }

    // Complaint Category Tests
    public function test_complaint_categories_index_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/complaint-categories');
        $response->assertStatus(200);
        $response->assertViewIs('admin.complaint-categories.index');
    }

    public function test_complaint_categories_create_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/complaint-categories/create');
        $response->assertStatus(200);
        $response->assertViewIs('admin.complaint-categories.create');
    }

    public function test_create_complaint_category(): void
    {
        $data = [
            'name' => 'Complaint Test',
            'slug' => 'complaint-test',
            'icon' => 'fa fa-complaint',
            'description' => 'Complaint Description',
            'order' => 1,
            'is_active' => true,
        ];

        $response = $this->actingAs($this->user)->post('/admin/complaint-categories', $data);
        $response->assertRedirect('/admin/complaint-categories');

        $this->assertDatabaseHas('complaint_categories', ['name' => 'Complaint Test']);
    }

    public function test_edit_complaint_category_page_loads(): void
    {
        $category = ComplaintCategory::create([
            'name' => 'Complaint Category',
            'slug' => 'complaint-category',
            'icon' => 'fa fa-complaint',
            'description' => 'Complaint Description',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->get("/admin/complaint-categories/{$category->id}/edit");
        $response->assertStatus(200);
        $response->assertViewIs('admin.complaint-categories.edit');
    }

    public function test_update_complaint_category(): void
    {
        $category = ComplaintCategory::create([
            'name' => 'Original Complaint',
            'slug' => 'original-complaint',
            'icon' => 'fa fa-original',
            'description' => 'Original Description',
            'order' => 1,
            'is_active' => true,
        ]);

        $data = [
            'name' => 'Updated Complaint',
            'slug' => 'updated-complaint',
            'icon' => 'fa fa-updated',
            'description' => 'Updated Description',
            'order' => 2,
            'is_active' => false,
        ];

        $response = $this->actingAs($this->user)->put("/admin/complaint-categories/{$category->id}", $data);
        $response->assertRedirect('/admin/complaint-categories');

        $this->assertDatabaseHas('complaint_categories', ['id' => $category->id, 'name' => 'Updated Complaint']);
    }

    public function test_delete_complaint_category(): void
    {
        $category = ComplaintCategory::create([
            'name' => 'Complaint Category',
            'slug' => 'complaint-category',
            'icon' => 'fa fa-complaint',
            'description' => 'Complaint Description',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->delete("/admin/complaint-categories/{$category->id}");
        $response->assertRedirect('/admin/complaint-categories');

        $this->assertDatabaseMissing('complaint_categories', ['id' => $category->id]);
    }

    // Validation Tests
    public function test_news_category_store_with_valid_data_creates_record(): void
    {
        $data = [
            'name' => 'Test News Category',
            'slug' => 'test-news-category',
            'icon' => 'fa fa-test',
            'description' => 'Test Description',
            'order' => 1,
            'is_active' => true,
        ];

        $this->actingAs($this->user)->post('/admin/news-categories', $data);
        $this->assertDatabaseHas('news_categories', ['name' => 'Test News Category']);
    }

    public function test_service_category_store_with_valid_data_creates_record(): void
    {
        $data = [
            'name' => 'Test Service Category',
            'slug' => 'test-service-category',
            'icon' => 'fa fa-test',
            'description' => 'Test Description',
            'order' => 1,
            'is_active' => true,
        ];

        $this->actingAs($this->user)->post('/admin/service-categories', $data);
        $this->assertDatabaseHas('service_categories', ['name' => 'Test Service Category']);
    }

    public function test_complaint_category_store_with_valid_data_creates_record(): void
    {
        $data = [
            'name' => 'Test Complaint Category',
            'slug' => 'test-complaint-category',
            'icon' => 'fa fa-test',
            'description' => 'Test Description',
            'order' => 1,
            'is_active' => true,
        ];

        $this->actingAs($this->user)->post('/admin/complaint-categories', $data);
        $this->assertDatabaseHas('complaint_categories', ['name' => 'Test Complaint Category']);
    }
}
