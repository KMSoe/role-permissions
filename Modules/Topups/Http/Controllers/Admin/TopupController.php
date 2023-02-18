<?php

namespace Modules\Topups\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Modules\Topups\Repositories\TopupRepository;

class TopupController extends Controller
{
    public function finishTopup($id, TopupRepository $topupRepo)
    {
        $item = $topupRepo->finishTopup($id);

        return Redirect::route('admin.topups.index')->with('success', 'Top up Finished');
    }
}