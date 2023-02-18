<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UserRepository $repo)
    {
        $user = Auth::user();

        $data = $repo->get($user->id);

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }
}
