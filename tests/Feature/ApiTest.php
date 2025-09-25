<?php
namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

class ApiTest extends TestCase {
    use RefreshDatabase;
    
    public function test_sql_injection_prevention() {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/loans', [
            'amount' => "1000'; DROP TABLE users; --"  // Malicious input
        ]);
        $response->assertStatus(422);  // Validation fails, no DB drop
    }
    
    public function test_xss_prevention() {
        $response = $this->get('/loans');  // Blade escapes {!! !!} avoided
        $response->assertSee('<script>alert("XSS")</script>', false);  // Not rendered
    }
    
    public function test_auth_bypass() {
        $response = $this->get('/admin/dashboard');  // No auth
        $response->assertRedirect('/login');
        
        $user = User::factory()->create(['role' => 'client']);
        $this->actingAs($user)->get('/admin/dashboard')->assertForbidden();
    }
    
    public function test_rate_limiting() {
        RateLimiter::clear('api:loans');  // Reset
        $user = User::factory()->create();
        $this->actingAs($user)->postJson('/api/loans')->assertOk();
        // Simulate 100 requests (throttle:60|1min in Kernel.php)
        $responses = [];
        for ($i = 0; $i < 100; $i++) {
            $responses[] = $this->actingAs($user)->postJson('/api/loans');
        }
        $responses[60]->assertStatus(429);  // Too Many Requests
    }
    
    public function test_csrf_protection() {
        $response = $this->post('/loans', []);  // No token
        $response->assertSessionHasErrors(['_token']);  // CSRF error
    }
}
