<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::where('role', 'user')->get();

        return response()->json([
            'success' => true,
            'data' => $members
        ]);
    }

    public function show(int $id)
    {
        $member = User::where('role', 'user')
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $member
        ]);
    }

    public function destroy(int $id)
    {
        $member = User::where('role', 'user')
            ->findOrFail($id);

        $member->delete();

        return response()->json([
            'success' => true,
            'message' => 'Anggota berhasil dihapus'
        ]);
    }
}