<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Sender extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
    ];

    /**
     * Gera um UUID quando um registro for criado
     */
    protected static function booted(): void
    {
        static::creating(function ($carrier) {
            $carrier->uuid = Str::uuid();
        });
    }

    /**
     * Informamos ao Laravel que vamos usar o uuid como identificador
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Busca as entregas relacionadas ao remetente
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }
}
