<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'publication_year' => $this->faker->date,
        ];
    }

    /**
     * Indicate that the book should belong to authors.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function configure()
    {
        return $this->afterCreating(function (Book $book) {
            $authors = Author::factory(rand(1, 3))->create();
            $book->authors()->attach($authors);
        });
    }
}
