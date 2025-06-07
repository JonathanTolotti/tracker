<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class RecipientAddress extends Model
{
    use HasFactory;

    protected $table = 'recipient_addresses';

    protected $fillable = [
        'uuid',
        'recipient_id',
        'street',
        'state',
        'zip_code',
        'country',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

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
     * Busca o destinatário deste endereço
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(Recipient::class);
    }

    /**
     * Busca as entregas deste endereço
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }

}
