<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PvitSetting extends Model
{
    protected $fillable = [
        'merchant_slug',
        'operation_account_code',
        'renew_password',
        'codeurl_renew','codeurl_rest','codeurl_link','codeurl_balance','codeurl_status',
        'callback_url_code','success_redirect_code','failed_redirect_code','secret_reception_code',
        'current_secret','secret_expires_at','meta'
    ];

    protected $casts = [
        'secret_expires_at' => 'datetime',
        'meta' => 'array',
    ];

    public static function one(): self
    {
        return static::query()->firstOrCreate([]);
    }
}