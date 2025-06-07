<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'volumes',
        'carrier_id',
        'sender_id',
        'recipient_id',
        'recipient_address_id',
    ];

    protected $casts = [
        'volumes' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Busca a transportadora da entrega
     */
    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Carrier::class);
    }

    /**
     * Busca o remetente da entrega
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(Sender::class);
    }

    /**
     * Busca o destinatário da entrega
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(Recipient::class, 'recipient_id');
    }

    /**
     * Busca o endereço desta entrega
     */
    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(RecipientAddress::class, 'recipient_address_id');
    }

    /**
     * Busca o status desta entrega
     */
    public function statuses(): HasMany
    {
        return $this->hasMany(DeliveryStatus::class)->orderBy('event_timestamp', 'asc');
    }
}
