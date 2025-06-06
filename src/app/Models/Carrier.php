<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Carrier extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'cnpj',
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
     * Busca as entregas relacionadas a transportadora
     *
     * @return HasMany
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }
}
