<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\PpidRequest;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaginationTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

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
    }

    /**
     * Test complaints are paginated in admin panel
     */
    public function test_complaints_are_paginated()
    {
        $category = ComplaintCategory::create([
            'name' => 'Infrastructure',
            'slug' => 'infrastructure',
        ]);

        // Create 30 complaints
        Complaint::factory()->count(30)->create([
            'complaint_category_id' => $category->id,
        ]);

        $response = $this->actingAs($this->adminUser)->get('/admin/complaints');

        $response->assertStatus(200);
        $pagination = $response->viewData('complaints');

        // Should only have 25 items per page
        $this->assertLessThanOrEqual(25, count($pagination->items()));
        $this->assertTrue($pagination->hasPages(), 'Pagination should have multiple pages');
    }

    /**
     * Test pagination links are present
     */
    public function test_pagination_links_present()
    {
        $category = ComplaintCategory::create([
            'name' => 'Test',
            'slug' => 'test',
        ]);

        Complaint::factory()->count(30)->create([
            'complaint_category_id' => $category->id,
        ]);

        $response = $this->actingAs($this->adminUser)->get('/admin/complaints');

        $pagination = $response->viewData('complaints');
        $this->assertTrue($pagination->hasPages());
    }

    /**
     * Test PPID requests pagination
     */
    public function test_ppid_requests_pagination()
    {
        PpidRequest::factory()->count(30)->create();

        $response = $this->actingAs($this->adminUser)->get('/admin/ppid-requests');

        $response->assertStatus(200);
        $pagination = $response->viewData('requests');

        $this->assertLessThanOrEqual(25, count($pagination->items()));
    }

    /**
     * Test contacts pagination
     */
    public function test_contacts_pagination()
    {
        Contact::factory()->count(30)->create();

        $response = $this->actingAs($this->adminUser)->get('/admin/contacts');

        $response->assertStatus(200);
        $pagination = $response->viewData('contacts');

        $this->assertLessThanOrEqual(25, count($pagination->items()));
    }

    /**
     * Test can navigate through pagination
     */
    public function test_can_navigate_pagination()
    {
        ComplaintCategory::create([
            'name' => 'Test',
            'slug' => 'test',
        ]);

        Complaint::factory()->count(50)->create();

        // Get first page
        $response = $this->actingAs($this->adminUser)->get('/admin/complaints');
        $response->assertStatus(200);

        // Get second page
        $response = $this->actingAs($this->adminUser)->get('/admin/complaints?page=2');
        $response->assertStatus(200);
    }
}
