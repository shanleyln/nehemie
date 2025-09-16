<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PvitSecretEvent extends Model
{
    protected $fillable = [
        'operation_account_code','secret_key','expires_in','raw_payload'
    ];
    protected $casts = [
        'raw_payload' => 'array',
    ];
}