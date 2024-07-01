<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        return Author::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
        ]);

        $author = Author::create($request->all());

        return response()->json($author, 201);
    }

    public function show($id)
    {
        return Author::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $author = Author::findOrFail($id);
        $author->update($request->all());

        return response()->json($author);
    }

    public function destroy($id)
    {
        Author::destroy($id);

        return response()->json(null, 204);
    }
}
