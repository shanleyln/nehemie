<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PvitSecret extends Model
{
    protected $table = 'pvit_secrets';

    // Pas besoin de tout remplir à la main si on utilise un upsert simple
    protected $fillable = [
        'account_code', 'secret_encrypted', 'expires_in', 'expires_at',
        'received_at', 'source_ip', 'version',
    ];

    protected $casts = [
        'expires_in'  => 'integer',
        'version'     => 'integer',
        'received_at' => 'datetime',
        'expires_at'  => 'datetime',
    ];

    // --- Attribut virtuel "secret" (clair) ---
    // Setter: on chiffre automatiquement vers secret_encrypted
    public function setSecretAttribute($value): void
    {
        $this->attributes['secret_encrypted'] = encrypt(trim((string)$value));
    }

    // Getter: on renvoie la valeur déchiffrée
    public function getSecretAttribute(): ?string
    {
        try {
            $enc = $this->attributes['secret_encrypted'] ?? null;
            return $enc ? decrypt($enc) : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    // Vérifie si le modèle est valide
    public function isValid(): bool
    {
        try {
            $this->validate();
            return true;
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('PvitSecret validation failed', [
                'errors' => $e->errors(),
                'attributes' => $this->attributes
            ]);
            return false;
        }
    }

    // Valide les attributs du modèle
    protected function validate()
    {
        $validator = \Validator::make($this->attributes, [
            'account_code' => 'required|string|max:50',
            'secret_encrypted' => 'required|string',
            'expires_in' => 'nullable|integer|min:0',
            'version' => 'required|integer|min:1',
            'received_at' => 'required|date',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }

    // Scope pratique
    public function scopeAccount($q, string $account)
    {
        return $q->where('account_code', $account);
    }
}
