<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RateLimitingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test complaint form has rate limiting
     */
    public function test_complaint_form_has_rate_limiting()
    {
        // Make multiple requests quickly
        for ($i = 0; $i < 12; $i++) {
            $response = $this->post('/pengaduan', [
                'name' => 'Test User ' . $i,
                'email' => 'test' . $i . '@example.com',
                'title' => 'Complaint ' . $i,
                'description' => 'Test complaint',
                'category' => 'infrastructure',
            ]);
        }

        // 11th request should be throttled (10 per minute limit)
        $response = $this->post('/pengaduan', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'title' => 'Complaint',
            'description' => 'Test complaint',
            'category' => 'infrastructure',
        ]);

        $this->assertEquals(429, $response->status());
    }

    /**
     * Test contact form has rate limiting
     */
    public function test_contact_form_has_rate_limiting()
    {
        for ($i = 0; $i < 12; $i++) {
            $this->post('/kontak', [
                'name' => 'Contact ' . $i,
                'email' => 'contact' . $i . '@example.com',
                'subject' => 'Subject',
                'message' => 'Message',
            ]);
        }

        $response = $this->post('/kontak', [
            'name' => 'Contact',
            'email' => 'contact@example.com',
            'subject' => 'Subject',
            'message' => 'Message',
        ]);

        $this->assertEquals(429, $response->status());
    }

    /**
     * Test PPID request form has stricter rate limiting (5 per minute)
     */
    public function test_ppid_request_has_stricter_rate_limiting()
    {
        for ($i = 0; $i < 7; $i++) {
            $this->post('/ppid/permohonan', [
                'name' => 'PPID Request ' . $i,
                'email' => 'ppid' . $i . '@example.com',
                'information_type' => 'general',
                'information_detail' => 'Details',
                'purpose' => 'personal',
                'method' => 'online',
            ]);
        }

        // 6th request should be throttled (5 per minute limit)
        $response = $this->post('/ppid/permohonan', [
            'name' => 'PPID Request',
            'email' => 'ppid@example.com',
            'information_type' => 'general',
            'information_detail' => 'Details',
            'purpose' => 'personal',
            'method' => 'online',
        ]);

        $this->assertEquals(429, $response->status());
    }
}
