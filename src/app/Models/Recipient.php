<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Recipient extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'cpf',
    ];

    /**
     * Gera um UUID quando um registro for criado
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function ($carrier) {
            $carrier->uuid = Str::uuid();
        });
    }

    /**
     * Informamos ao Laravel que vamos usar o uuid como identificador
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
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
