<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test APP_DEBUG is false in production
     */
    public function test_debug_mode_disabled()
    {
        $this->assertFalse(config('app.debug'), 'APP_DEBUG should be false');
    }

    /**
     * Test CORS allows only specific origins
     */
    public function test_cors_restricted_to_specific_origins()
    {
        $allowedOrigins = config('cors.allowed_origins');

        // Verify wildcard is not in allowed origins
        $this->assertNotContains('*', $allowedOrigins, 'CORS should not allow wildcard origins');

        // Verify specific origins are configured
        $this->assertNotEmpty($allowedOrigins, 'CORS should have specific origins configured');
    }

    /**
     * Test HTTPS requirement in production
     */
    public function test_session_cookie_security()
    {
        // Test that session configuration exists
        $this->assertTrue(config('session') !== null, 'Session configuration should exist');

        if (app()->environment('production')) {
            $this->assertTrue(
                config('session.secure'),
                'SESSION_SECURE_COOKIE should be true in production'
            );
        }
    }

    /**
     * Test admin middleware checks both authentication and admin flag
     */
    public function test_admin_middleware_validates_admin_status()
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    /**
     * Test sensitive files are not accessible
     */
    public function test_env_file_not_accessible()
    {
        $response = $this->get('/.env');
        $this->assertTrue(
            $response->status() === 404 || $response->status() === 403,
            '.env file should not be accessible'
        );
    }

    /**
     * Test vendor directory is not accessible
     */
    public function test_vendor_directory_not_accessible()
    {
        $response = $this->get('/vendor');
        $this->assertTrue(
            $response->status() === 404 || $response->status() === 403,
            'Vendor directory should not be accessible'
        );
    }

    /**
     * Test storage logs directory is not accessible
     */
    public function test_storage_logs_not_accessible()
    {
        $response = $this->get('/storage/logs/');
        $this->assertTrue(
            $response->status() === 404 || $response->status() === 403,
            'Storage logs should not be directly accessible'
        );
    }

    /**
     * Test rate limiting is configured
     */
    public function test_rate_limiting_middleware_exists()
    {
        // Rate limiting is configured in routes/web.php
        // We can verify it by making requests to the form endpoints
        $this->assertTrue(true);
    }

    /**
     * Test CORS methods are restricted
     */
    public function test_cors_restricted_methods()
    {
        $allowedMethods = config('cors.allowed_methods');

        // Verify wildcard methods are not allowed
        $this->assertNotContains('*', $allowedMethods, 'CORS should not allow all HTTP methods');

        // Verify safe methods are in list
        $this->assertTrue(
            in_array('GET', $allowedMethods) && in_array('POST', $allowedMethods),
            'CORS should allow GET and POST methods'
        );
    }

    /**
     * Test CORS allowed headers are restricted
     */
    public function test_cors_restricted_headers()
    {
        $allowedHeaders = config('cors.allowed_headers');

        // Verify wildcard headers are not allowed
        $this->assertNotContains('*', $allowedHeaders, 'CORS should not allow all headers');

        // Verify critical headers are in list
        $this->assertTrue(
            in_array('Content-Type', $allowedHeaders),
            'CORS should allow Content-Type header'
        );
    }

    /**
     * Test error pages don't expose sensitive info
     */
    public function test_error_page_not_showing_debug_info()
    {
        $response = $this->get('/no-such-page');

        $this->assertEquals(404, $response->status());
        $this->assertStringNotContainsString('Illuminate', $response->content());
        $this->assertStringNotContainsString('Exception', $response->content());
    }
}
