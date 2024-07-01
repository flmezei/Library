<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
    }

    public function test_can_create_author()
    {
        $this->authenticate();

        $response = $this->postJson('/api/authors', [
            'name' => 'Author Name',
            'date_of_birth' => '1980-01-01',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'name', 'date_of_birth']);
    }

    public function test_can_list_authors()
    {
        $this->authenticate();

        Author::factory()->count(5)->create();

        $response = $this->getJson('/api/authors');

        $response->assertStatus(200)
                 ->assertJsonCount(5);
    }

    public function test_can_update_author()
    {
        $this->authenticate();

        $author = Author::factory()->create();

        $response = $this->putJson("/api/authors/{$author->id}", [
            'name' => 'Updated Name',
            'date_of_birth' => '1990-01-01',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $author->id,
                     'name' => 'Updated Name',
                     'date_of_birth' => '1990-01-01',
                 ]);
    }

    public function test_can_delete_author()
    {
        $this->authenticate();

        $author = Author::factory()->create();

        $response = $this->deleteJson("/api/authors/{$author->id}");

        $response->assertStatus(204);
    }
}
