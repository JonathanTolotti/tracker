<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carrier extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'cnpj',
    ];

    /**
     * Informamos ao Laravel que vamos usar o uuid como identificador
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Busca as entregas relacionadas a transportadora
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }
}
