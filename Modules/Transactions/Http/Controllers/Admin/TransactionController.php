<?php

namespace Modules\Transactions\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Modules\Transactions\models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        return Inertia::render('Modules/Transactions/Admin/Index', []);
    }

    public function destroy($id)
    {
        $transition = Transaction::findOrFail($id);
        $transition->delete();

        return Redirect::route('admin.transactions.index')->with('success', 'Successfully deleted');
    }
}
