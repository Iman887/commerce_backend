<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        // optional filtering
        if ($request->has('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }

        return response()->json($query->get());
    }

    public function show($id)
    {
        $book = Book::with('category')->find($id);
        if (!$book) return response()->json(['message' => 'Book not found'], 404);
        return response()->json($book);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric',
            'pages' => 'required|integer',
            'description' => 'nullable|string',
            'publication_year' => 'required|integer',
            'cover_image' => 'nullable|string',
            'epub_file' => 'nullable|string',
            'rating' => 'nullable|integer',
            'total_sold' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $book = Book::create($data);

        return response()->json($book, 201);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) return response()->json(['message' => 'Book not found'], 404);

        $data = $request->validate([
            'category_id' => 'sometimes|required|exists:categories,id',
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'pages' => 'sometimes|required|integer',
            'description' => 'nullable|string',
            'publication_year' => 'sometimes|required|integer',
            'cover_image' => 'nullable|string',
            'epub_file' => 'nullable|string',
            'rating' => 'nullable|integer',
            'total_sold' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $book->update($data);

        return response()->json($book);
    }

    /**
     * Soft-delete / toggle active state by changing is_active boolean
     */
    public function delete(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) return response()->json(['message' => 'Book not found'], 404);

        // If client provides is_active explicitly, set it; otherwise toggle
        if ($request->has('is_active')) {
            $book->is_active = (bool) $request->get('is_active');
        } else {
            $book->is_active = !$book->is_active;
        }

        $book->save();

        return response()->json($book);
    }
}
