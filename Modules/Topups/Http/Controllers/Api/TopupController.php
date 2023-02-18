<?php

namespace Modules\Topups\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Modules\Images\Helpers\ImageHelper;
use Modules\Topups\Repositories\TopupRepository;

class TopupController extends Controller
{
    public function index()
    {
        
    }

    public function show($key)
    {

    }

    public function create()
    {
        
    }

    public function store(Request $request, TopupRepository $topupRepo)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'description' => 'nullable',
            'payment_slip' => 'required|image|mimes:png,jpg,jpeg,svg',
            'user_email' => 'nullable',
            'user_phone' => 'nullable',
            'payment_method_id' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->getMessageBag(),
                'message' => 'Fails'
            ], 422);
        }

        $data = [
            'user_id' => $user->id,
            'amount' => Request::get('amount'),
            'description' => Request::get('description'),
            'payment_method_id' => Request::get('payment_method_id'),
            'payment_slip' => Request::file('payment_slip'),
            'user_email' => Request::get('user_email') ?? null,
            'user_phone' => Request::get('user_phone') ?? null,
        ];

        $item = $topupRepo->store((object)$data);

        return response()->json([
            'status' => true,
            'data' => $item,
            'message' => 'Top up Successful',
        ], 201);
    }
}