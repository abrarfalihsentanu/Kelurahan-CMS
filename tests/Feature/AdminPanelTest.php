<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminPanelTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::first();
    }

    public function test_login_page_loads(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_admin_redirects_when_not_authenticated(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_admin_dashboard(): void
    {
        $response = $this->actingAs($this->user)->get('/admin');
        $response->assertStatus(200);
    }

    public function test_admin_settings(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/settings');
        $response->assertStatus(200);
    }

    public function test_admin_sliders_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/sliders');
        $response->assertStatus(200);
    }

    public function test_admin_sliders_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/sliders/create');
        $response->assertStatus(200);
    }

    public function test_admin_statistics_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/statistics');
        $response->assertStatus(200);
    }

    public function test_admin_statistics_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/statistics/create');
        $response->assertStatus(200);
    }

    public function test_admin_galleries_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/galleries');
        $response->assertStatus(200);
    }

    public function test_admin_galleries_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/galleries/create');
        $response->assertStatus(200);
    }

    public function test_admin_news_categories_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/news-categories');
        $response->assertStatus(200);
    }

    public function test_admin_news_categories_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/news-categories/create');
        $response->assertStatus(200);
    }

    public function test_admin_news_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/news');
        $response->assertStatus(200);
    }

    public function test_admin_news_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/news/create');
        $response->assertStatus(200);
    }

    public function test_admin_pages_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/pages');
        $response->assertStatus(200);
    }

    public function test_admin_pages_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/pages/create');
        $response->assertStatus(200);
    }

    public function test_admin_divisions_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/divisions');
        $response->assertStatus(200);
    }

    public function test_admin_divisions_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/divisions/create');
        $response->assertStatus(200);
    }

    public function test_admin_officials_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/officials');
        $response->assertStatus(200);
    }

    public function test_admin_officials_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/officials/create');
        $response->assertStatus(200);
    }

    public function test_admin_service_categories_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/service-categories');
        $response->assertStatus(200);
    }

    public function test_admin_service_categories_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/service-categories/create');
        $response->assertStatus(200);
    }

    public function test_admin_services_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/services');
        $response->assertStatus(200);
    }

    public function test_admin_services_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/services/create');
        $response->assertStatus(200);
    }

    public function test_admin_service_hours_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/service-hours');
        $response->assertStatus(200);
    }

    public function test_admin_service_hours_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/service-hours/create');
        $response->assertStatus(200);
    }

    public function test_admin_agendas_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/agendas');
        $response->assertStatus(200);
    }

    public function test_admin_agendas_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/agendas/create');
        $response->assertStatus(200);
    }

    public function test_admin_achievements_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/achievements');
        $response->assertStatus(200);
    }

    public function test_admin_achievements_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/achievements/create');
        $response->assertStatus(200);
    }

    public function test_admin_infographics_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/infographics');
        $response->assertStatus(200);
    }

    public function test_admin_infographics_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/infographics/create');
        $response->assertStatus(200);
    }

    public function test_admin_potentials_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/potentials');
        $response->assertStatus(200);
    }

    public function test_admin_potentials_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/potentials/create');
        $response->assertStatus(200);
    }

    public function test_admin_complaint_categories_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/complaint-categories');
        $response->assertStatus(200);
    }

    public function test_admin_complaint_categories_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/complaint-categories/create');
        $response->assertStatus(200);
    }

    public function test_admin_complaints_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/complaints');
        $response->assertStatus(200);
    }

    public function test_admin_ppid_categories_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/ppid-categories');
        $response->assertStatus(200);
    }

    public function test_admin_ppid_categories_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/ppid-categories/create');
        $response->assertStatus(200);
    }

    public function test_admin_ppid_documents_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/ppid-documents');
        $response->assertStatus(200);
    }

    public function test_admin_ppid_documents_create(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/ppid-documents/create');
        $response->assertStatus(200);
    }

    public function test_admin_ppid_requests_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/ppid-requests');
        $response->assertStatus(200);
    }

    public function test_admin_contacts_index(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/contacts');
        $response->assertStatus(200);
    }

    // Test edit routes with existing records
    public function test_admin_sliders_edit(): void
    {
        $item = \App\Models\Slider::first();
        if ($item) {
            $response = $this->actingAs($this->user)->get("/admin/sliders/{$item->id}/edit");
            $response->assertStatus(200);
        } else {
            $this->assertTrue(true); // skip
        }
    }

    public function test_admin_news_edit(): void
    {
        $item = \App\Models\News::first();
        if ($item) {
            $response = $this->actingAs($this->user)->get("/admin/news/{$item->id}/edit");
            $response->assertStatus(200);
        } else {
            $this->assertTrue(true);
        }
    }

    public function test_admin_officials_edit(): void
    {
        $item = \App\Models\Official::first();
        if ($item) {
            $response = $this->actingAs($this->user)->get("/admin/officials/{$item->id}/edit");
            $response->assertStatus(200);
        } else {
            $this->assertTrue(true);
        }
    }

    public function test_admin_services_edit(): void
    {
        $item = \App\Models\Service::first();
        if ($item) {
            $response = $this->actingAs($this->user)->get("/admin/services/{$item->id}/edit");
            $response->assertStatus(200);
        } else {
            $this->assertTrue(true);
        }
    }

    // Test login functionality
    public function test_login_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);
        $response->assertRedirect('/admin');
    }

    public function test_login_with_invalid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'wrong@email.com',
            'password' => 'wrongpassword',
        ]);
        $response->assertSessionHasErrors('email');
    }

    // Test frontend pages still work
    public function test_frontend_home(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_frontend_pages(): void
    {
        $pages = ['/', '/perangkat', '/layanan', '/informasi', '/berita', '/pengaduan', '/ppid', '/kontak'];
        foreach ($pages as $page) {
            $response = $this->get($page);
            $response->assertStatus(200, "Page {$page} failed");
        }
    }
}
