<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
    }

    public function test_can_create_loan()
    {
        $this->authenticate();

        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->postJson('/api/loans', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'loan_date' => now()->format('Y-m-d'),
            'return_date' => now()->addDays(7)->format('Y-m-d'), // Example: return in 7 days
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id',
                     'user_id',
                     'book_id',
                     'loan_date',
                     'return_date',
                     'user',
                     'book',
                 ]);
    }

    public function test_can_list_loans()
    {
        $this->authenticate();

        Loan::factory()->count(5)->create();

        $response = $this->getJson('/api/loans');

        $response->assertStatus(200)
                 ->assertJsonCount(5);
    }
}
