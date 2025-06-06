<?php

namespace App\Repository;

use App\Models\Delivery;
use Illuminate\Support\Collection;

class DeliveryRepository
{
    /**
     * Busca uma entrega pelo UUID
     *
     * @param string $uuid
     * @return Delivery|null
     */
    public function findByUuid(string $uuid): ?Delivery
    {
        return Delivery::query()->with([
            'carrier',
            'sender',
            'recipient',
            'shippingAddress',
            'statuses'
        ])->where('uuid', $uuid)->first();
    }

    /**
     * Busca uma entrega pelo ID do destinatário
     *
     * @param int $recipientId
     * @return Collection
     */
    public function findByRecipientId(int $recipientId): Collection
    {
        return Delivery::query()->with(['carrier', 'shippingAddress', 'statuses'])
            ->where('recipient_id', $recipientId)
            ->get();
    }

    /**
     * Cria uma nova entrega
     *
     * @param array $data
     * @return Delivery
     */
    public function create(array $data): Delivery
    {
        return Delivery::query()->create($data);
    }
}
