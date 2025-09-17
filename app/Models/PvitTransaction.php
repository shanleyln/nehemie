<?php

// app/Models/PvitTransaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PvitTransaction extends Model
{
    protected $fillable = [
      'request_type','service','transaction_type','reference','reference_id','status','operator',
      'merchant_operation_account_code','amount','customer_account_number','owner_charge','operator_owner_charge',
      'request_payload','response_payload'
    ];
    protected $casts = ['request_payload' => 'array','response_payload' => 'array','amount' => 'decimal:2'];
}