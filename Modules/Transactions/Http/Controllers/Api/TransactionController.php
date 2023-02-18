<?php

namespace Modules\Transactions\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Modules\Transactions\models\Transaction;
use Modules\Transactions\Repositories\TransactionRepository;

class TransactionController extends Controller
{
    public function index()
    {
        
    }

    public function store(Request $request, TransactionRepository $repo)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required',
            'amount' => 'required',
            'note' => 'nullable',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->getMessageBag(),
                'message' => 'Fails',
            ], 422);
        }

        $user = Auth::user();
        $receiver = User::findOrFail($request->receiver_id);

        if (!$receiver) {
            return response()->json([
                'status' => false,
                'errors' => [],
                'message' => 'Receiver not found',
            ], 422);
        }

        $data = [
            "sender" => $user,
            "receiver" => $receiver,
            "amount" => $request->amount,
            "note" => $request->note,
        ];

        $item = $repo->store((object)$data);

        return response()->json([
            'status' => true,
            'data' => $item,
            'message' => "Successfully transferred"
        ], 201);
    }

}
