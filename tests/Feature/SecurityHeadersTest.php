<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test security headers are present on public web pages.
     */
    public function test_security_headers_are_present_on_public_pages(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
    }

    /**
     * Test security headers are present on admin login page.
     */
    public function test_security_headers_are_present_on_admin_login(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    /**
     * Test HSTS is added when request is secure (HTTPS).
     */
    public function test_hsts_header_is_added_on_https_requests(): void
    {
        $response = $this->get('https://localhost/');

        $response->assertStatus(200);
        $response->assertHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
    }
}
