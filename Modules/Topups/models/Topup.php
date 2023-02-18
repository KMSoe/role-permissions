<?php

namespace Modules\Topups\models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topup extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'topups';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}