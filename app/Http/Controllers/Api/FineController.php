<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fine;

class FineController extends Controller
{
    public function index()
    {
        $fines = Fine::with([
            'borrowing.user',
            'borrowing.book'
        ])->get();

        return response()->json([
            'success' => true,
            'data' => $fines
        ]);
    }
}