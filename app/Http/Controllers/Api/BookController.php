<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Book::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:books,code',
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'year' => 'required',
            'stock' => 'required|integer|min:0'
        ]);

        $book = Book::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil ditambahkan',
            'data' => $book
        ], 201);
    }

    public function show(string $id)
    {
        $book = Book::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $book
        ]);
    }

    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $book->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil diupdate',
            'data' => $book
        ]);
    }

    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus'
        ]);
    }
}