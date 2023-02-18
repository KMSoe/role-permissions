<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function searchByPhone(Request $request)
    {
        $search = $request->search;

        $users = User::where('name', 'LIKE', '%' . $search . '%')
            ->orwhere('email', 'LIKE', '%' . $search . '%')
            ->orwhere('phone', 'LIKE', '%' . $search . '%')
            ->select('id', 'name', 'email', 'phone', 'photo')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $users
        ]);
    }
}
