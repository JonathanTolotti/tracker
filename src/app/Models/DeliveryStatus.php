<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class DeliveryStatus extends Model
{
    use HasFactory;

    protected $table = 'delivery_statuses';

    protected $fillable = [
        'delivery_id',
        'message',
        'event_timestamp',
    ];

    protected $casts = [
        'event_timestamp' => 'datetime',
    ];

    /**
     * Busca a entrega que tem os eventos
     */
    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }
}
