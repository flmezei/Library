<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
    }

    public function test_can_create_book()
    {
        $this->authenticate();

        $author = Author::factory()->create();

        $response = $this->postJson('/api/books', [
            'title' => 'Book Title',
            'publication_year' => '2021-10-25',
            'author_ids' => [$author->id],
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'title', 'publication_year', 'authors']);
    }

    public function test_can_list_books()
    {
        $this->authenticate();

        Book::factory()->count(5)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
                 ->assertJsonCount(5);
    }

    public function test_can_update_book()
    {
        $this->authenticate();

        $book = Book::factory()->create();
        $author = Author::factory()->create();

        $response = $this->putJson("/api/books/{$book->id}", [
            'title' => 'Updated Title',
            'publication_year' => '2021-10-25',
            'author_ids' => [$author->id],
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $book->id,
                     'title' => 'Updated Title',
                     'publication_year' => '2021-10-25',
                     'authors' => [
                         ['id' => $author->id, 'name' => $author->name, 'date_of_birth' => $author->date_of_birth],
                     ],
                 ]);
    }

    public function test_can_delete_book()
    {
        $this->authenticate();

        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(204);
    }
}
