<?php

namespace Modules\Transactions\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Modules\Cashbooks\Models\Cashbook;
use Modules\Core\Helpers\CoreHelper;
use Modules\Images\Helpers\ImageHelper;
use Modules\Topups\models\Topup;
use Modules\Transactions\models\Transaction;

class TransactionRepository
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
        $sender = $data->sender;
        $receiver = $data->receiver;

        $now = Carbon::now();

        $item = new Transaction();
        $item->sender_id = $sender->id;
        $item->receiver_id = $receiver->id;
        $item->key = CoreHelper::generateRandomString('', 6);
        $item->amount = $data->amount;
        $item->note = $data->note;
        $item->contact_email = $data->contact_email ?? $receiver->email;
        $item->contact_phone = $data->contact_phone ?? $receiver->phone;

        $item->status = 1;
        $item->finish_time = $now;
        $item->save();

        // Save Cashbooks for sender and receiver
        Cashbook::insert([
            [
                'ref_no' => $item->id,
                'action' => 2,
                'user_id' => $sender->id,
                'dr' => 0,
                'cr' => $item->amount,
                'description' => "Balance Transferred",
                'remark' => "",
            ],
            [
                'ref_no' => $item->id,
                'action' => 2,
                'user_id' => $receiver->id,
                'dr' => $item->amount,
                'cr' => 0,
                'description' => "Balance received",
                'remark' => "",
            ]
        ]);

        $sender->balance -= $item->amount;
        $receiver->balance += $item->amount;

        $sender->save();
        $receiver->save();

        return $item;
    }
}
