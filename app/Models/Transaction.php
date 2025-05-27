<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;
    public $incrementing = false; // Ne pas incrémenter (UUID)
    protected $keyType = 'string'; // Type string pour UUID

    protected $fillable = [
        'id', 'reference', 'montant', 'status'
    ];

    protected static function boot()
    {
        parent::boot();

        // Générer un UUID automatiquement si non fourni
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
