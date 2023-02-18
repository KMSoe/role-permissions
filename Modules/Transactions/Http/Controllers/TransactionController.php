<?php

namespace Modules\Transactions\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Modules\Images\Helpers\ImageHelper;
use Modules\Transactions\models\Transaction;
use Modules\Transactions\Repositories\TransactionRepository;

class TransactionController extends Controller
{
    public function index()
    {
        return Inertia::render('Modules/Transactions/Site/Index', [
            'filters' => Request::all('search', 'trashed'),
            'topups' => []
        ]);
    }

    public function show($key)
    {
    }

    public function create()
    {
        $search = Request::get('search');

        return Inertia::render('Modules/Transactions/Site/Create', [
            'filters' => Request::all('search'),
            'users' => $search ? User::where('name', 'LIKE', '%' . $search . '%')
                ->orwhere('email', 'LIKE', '%' . $search . '%')
                ->orwhere('phone', 'LIKE', '%' . $search . '%')
                ->select('id', 'name', 'email', 'phone', 'photo')
                ->get() : collect(),
        ]);
    }

    public function store(TransactionRepository $repo)
    {
        $user = Auth::user();

        Request::validate([
            "receiver_id" => "required",
            "email" => "",
            "phone" => "",
            "amount" => 'required',
            "contact_email" => "nullable",
            "contact_phone" => "nullable",
            "note" => "nullable"
        ]);

        $receiver = User::findOrFail(Request::get('receiver_id'));

        if (!$receiver) {
            return back()->with('error', 'Receiver Not Found');
        }

        $data = [
            "sender" => $user,
            "receiver" => $receiver,
            "amount" => Request::get('amount'),
            "note" => Request::get('note'),
        ];

        $item = $repo->store((object)$data);

        return Redirect::route('transactions.index')->with('success', 'Successfully Transferred');
    }
}
