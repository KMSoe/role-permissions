<?php

namespace Modules\Topups\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Modules\Cashbooks\Models\Cashbook;
use Modules\Core\Helpers\CoreHelper;
use Modules\Images\Helpers\ImageHelper;
use Modules\Topups\models\Topup;

class TopupRepository
{
    public function all()
    {
        return Topup::all();
    }

    public function getByUser(User $user)
    {
        return Topup::where('user_id', $user->id)->get();
    }

    public function store($data)
    {
        $item = new Topup();
        $item->user_id = $data->user_id;
        $item->key = CoreHelper::generateRandomString("", 6);
        $item->amount = $data->amount;
        $item->payment_method_id = $data->payment_method_id;
        $item->description = $data->description;
        $item->user_email = $data->user_email;
        $item->user_phone = $data->user_phone;

        if ($data->payment_slip) {
            $image = ImageHelper::storeImageWithFixedSize($data->payment_slip, 'top-up', 'app/public/images/topups');
            $item->payment_slip = $image;
        }

        $item->save();

        return $item;
    }

    public function finishTopup($id) 
    {
        $now = Carbon::now();

        $item = Topup::findOrFail($id);
        $item->status = 1;
        $item->finish_time = $now;
        $item->save();

        $cashbook = new Cashbook();
        $cashbook->ref_no = $item->id;
        $cashbook->user_id = $item->user_id;
        $cashbook->action = 1;
        $cashbook->dr = $item->amount;
        $cashbook->cr = 0;
        $cashbook->description = 'Top up';
        $cashbook->remark = null;
        $cashbook->save();

        return $item;
    }
}
