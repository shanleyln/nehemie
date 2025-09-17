<?php

// app/Models/PvitCallback.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PvitCallback extends Model
{
    protected $fillable = [
      'transaction_id','merchant_reference_id','status','amount','fees',
      'charge_owner','transaction_operation','operator','raw_payload'
    ];
    protected $casts = ['raw_payload' => 'array','amount' => 'decimal:2','fees' => 'decimal:2'];
}