<?php

namespace Modules\Topups\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Modules\Images\Helpers\ImageHelper;
use Modules\PaymentMethods\Models\PaymentMethod;
use Modules\Topups\Repositories\TopupRepository;

class TopupController extends Controller
{
    public function index()
    {
        return Inertia::render('Modules/Topups/Site/Index', [
            'filters' => Request::all('search', 'trashed'),
            'topups' => []
        ]);
    }

    public function show($key)
    {
        return Inertia::render('Modules/Topups/Site/Index', [
            'filters' => Request::all('search', 'trashed'),
            'topups' => []
        ]);
    }

    public function create()
    {
        $payment_methods = PaymentMethod::where('status', 1)
            ->get();

        return Inertia::render('Modules/Topups/Site/Create', [
            'payment_methods' => $payment_methods
        ]);
    }

    public function store(TopupRepository $topupRepo)
    {
        $user = Auth::user();

        Request::validate([
            'amount' => 'required',
            'description' => 'nullable',
            'payment_slip' => 'required|image|mimes:png,jpg,jpeg,svg',
            'user_email' => 'nullable',
            'user_phone' => 'nullable',
            'payment_method_id' => 'required',
        ]);

        $data = [
            'user_id' => $user->id,
            'amount' => Request::get('amount'),
            'description' => Request::get('description'),
            'payment_method_id' => Request::get('payment_method_id'),
            'payment_slip' => Request::file('payment_slip'),
            'user_email' => Request::get('user_email') ?? null,
            'user_phone' => Request::get('user_phone') ?? null,
        ];

        $topupRepo->store((object)$data);

        return Redirect::route('topups.index')->with('success', 'Successfully Top up');
    }
}
