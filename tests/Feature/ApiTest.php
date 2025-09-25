<?php
namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Http;

class ApiTest extends TestCase {
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        // Seed roles
        \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        \Spatie\Permission\Models\Role::create(['name' => 'staff']);
        \Spatie\Permission\Models\Role::create(['name' => 'client']);
    }

    public function test_sql_injection_prevention() {
        $user = User::factory()->create(['role' => 'client'])->assignRole('client');
        $response = $this->actingAs($user)->postJson('/api/loans', [
            'amount' => "1000'; DROP TABLE users; --",
            'term_months' => 12,
            'interest_rate' => 10,
        ]);
        $response->assertStatus(422); // Validation fails
        $this->assertDatabaseMissing('users', ['email' => null]); // No table drop
    }

    public function test_xss_prevention() {
        $response = $this->get('/client/loans');
        $response->assertSee('<script>alert("XSS")</script>', false); // Escaped in Blade
    }

    public function test_unauthenticated_access() {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');

        $response = $this->getJson('/api/loans');
        $response->assertStatus(401); // Unauthorized
    }

    public function test_role_based_access_control() {
        $client = User::factory()->create(['role' => 'client'])->assignRole('client');
        $staff = User::factory()->create(['role' => 'staff'])->assignRole('staff');

        // Client accessing admin route
        $response = $this->actingAs($client)->get('/admin/dashboard');
        $response->assertStatus(403); // Forbidden

        // Staff accessing client route
        $response = $this->actingAs($staff)->get('/client/dashboard');
        $response->assertStatus(403);
    }

    public function test_rate_limiting() {
        RateLimiter::clear('api');
        $user = User::factory()->create(['role' => 'client'])->assignRole('client');

        // Simulate 100 requests (throttle:60,1 in Kernel.php)
        $responses = [];
        for ($i = 0; $i < 100; $i++) {
            $responses[] = $this->actingAs($user)->postJson('/api/loans', [
                'amount' => 1000,
                'term_months' => 12,
                'interest_rate' => 10,
            ]);
        }
        $responses[0]->assertStatus(201); // First succeeds
        $responses[60]->assertStatus(429); // Too Many Requests
    }

    public function test_csrf_protection() {
        $user = User::factory()->create(['role' => 'client'])->assignRole('client');
        $response = $this->actingAs($user)->post('/client/loans', []); // No CSRF token
        $response->assertSessionHasErrors(['_token']);
    }

    public function test_mpesa_api_security() {
        $user = User::factory()->create(['role' => 'client'])->assignRole('client');
        $loan = Loan::factory()->create(['client_id' => $user->id]);

        // Fake M-Pesa response
        Http::fake([
            'https://sandbox.safaricom.co.ke/*' => Http::response(['CheckoutRequestID' => 'test123'], 200),
        ]);

        $response = $this->actingAs($user)->postJson('/mpesa/stk', [
            'amount' => 100,
            'phone' => '254712345678',
            'loan_id' => $loan->id,
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['CheckoutRequestID']);
    }

    public function test_crypto_api_security() {
        $user = User::factory()->create(['role' => 'client'])->assignRole('client');
        $loan = Loan::factory()->create(['client_id' => $user->id]);

        // Fake Coinremitter response
        Http::fake([
            'https://coinremitter.com/api/v3/*' => Http::response(['success' => true, 'data' => ['payment_url' => 'https://pay.coinremitter.com']], 200),
        ]);

        $response = $this->actingAs($user)->postJson('/crypto/pay', [
            'amount' => 100,
            'loan_id' => $loan->id,
        ]);
        $response->assertRedirect(); // Redirects to payment URL
    }

    public function test_file_upload_security() {
        $user = User::factory()->create(['role' => 'client'])->assignRole('client');
        
        // Test malicious file upload
        $response = $this->actingAs($user)->post('/client/profile', [
            'id_document' => \Illuminate\Http\UploadedFile::fake()->create('malware.exe', 1000),
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $response->assertStatus(422); // Rejected due to mime validation
    }
}
