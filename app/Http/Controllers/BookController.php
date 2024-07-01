<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return Book::with('authors')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publication_year' => 'required|date',
            'author_ids' => 'required|array',
            'author_ids.*' => 'exists:authors,id',
        ]);

        $book = Book::create($request->only(['title', 'publication_year']));
        $book->authors()->attach($request->author_ids);

        return response()->json($book->load('authors'), 201);
    }

    public function show($id)
    {
        return Book::with('authors')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->only(['title', 'publication_year']));
        $book->authors()->sync($request->author_ids);

        return response()->json($book->load('authors'));
    }

    public function destroy($id)
    {
        Book::destroy($id);

        return response()->json(null, 204);
    }
}
