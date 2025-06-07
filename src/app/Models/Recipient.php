<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Recipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'cpf',
    ];

    /**
     * Gera um UUID quando um registro for criado
     */
    protected static function booted(): void
    {
        static::creating(function ($carrier): void {
            $carrier->uuid = Str::uuid();
        });
    }

    /**
     * Busca as entregas do destinatário
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }

    /**
     * Busca os endereços do destinatário
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(RecipientAddress::class);
    }
}
