<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\Fine;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    /**
     * User mengajukan peminjaman
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if ($book->stock <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Stok buku habis'
            ], 400);
        }

        $borrowing = Borrowing::create([
            'user_id' => $request->user()->id,
            'book_id' => $book->id,
            'borrow_date' => now(),
            'due_date' => now()->addDays(7),
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permohonan peminjaman berhasil diajukan',
            'data' => $borrowing
        ], 201);
    }

    /**
     * Admin melihat semua peminjaman
     */
    public function index()
    {
        $borrowings = Borrowing::with([
            'user',
            'book',
            'fine'
        ])->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $borrowings
        ]);
    }

    /**
     * User melihat riwayat peminjaman
     */
    public function myBorrowings()
    {
        $borrowings = Borrowing::with([
            'book',
            'fine'
        ])
        ->where('user_id', request()->user()->id)
        ->latest()
        ->get();

        return response()->json([
            'success' => true,
            'data' => $borrowings
        ]);
    }

    /**
     * Admin approve peminjaman
     */
    public function approve(int $id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman sudah diproses'
            ], 400);
        }

        $book = $borrowing->book;

        if ($book->stock <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Stok buku habis'
            ], 400);
        }

        $book->decrement('stock');

        $borrowing->update([
            'status' => 'approved'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil disetujui'
        ]);
    }

    /**
     * Admin konfirmasi pengembalian
     */
    public function returnBook(int $id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Buku belum dipinjam'
            ], 400);
        }

        $returnDate = Carbon::now();

        $borrowing->update([
            'status' => 'returned',
            'return_date' => $returnDate
        ]);

        $borrowing->book->increment('stock');

        if ($returnDate->gt(Carbon::parse($borrowing->due_date))) {

            $lateDays = Carbon::parse(
                $borrowing->due_date
            )->diffInDays($returnDate);

            Fine::create([
                'borrowing_id' => $borrowing->id,
                'amount' => $lateDays * 1000,
                'status' => 'unpaid'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pengembalian berhasil diproses'
        ]);
    }
}