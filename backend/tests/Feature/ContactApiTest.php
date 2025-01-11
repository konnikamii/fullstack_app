<?php

// filepath: /d:/PhpFiles/vite_vue/backend2/tests/Feature/ContactApiTest.php

namespace Tests\Feature;

use App\Models\Contacts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_fetch_csrf_token()
    {
        $response = $this->getJson('/api/csrf-token');

        $response->assertStatus(200)
            ->assertJsonStructure(['csrf_token']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_contact()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test Message',
        ];

        $response = $this->postJson('/api/contacts', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['success' => true]);

        $this->assertDatabaseHas('contacts', $data);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_fetch_all_contacts()
    {
        Contacts::factory()->count(3)->create();

        $response = $this->getJson('/api/contacts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'subject',
                        'message',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }
}
