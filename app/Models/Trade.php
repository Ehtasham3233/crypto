<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Trade extends Model
{
    protected $fillable = ['user_id', 'amount', 'type', 'duration', 'btc_price', 'trade_start', 'trade_end', 'status',  'expiry_time'];
}
