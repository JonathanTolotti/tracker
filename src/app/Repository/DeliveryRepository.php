<?php

namespace App\Repository;

use App\Models\Delivery;
use App\Repository\Contracts\DeliveryRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class DeliveryRepository implements DeliveryRepositoryInterface
{
    /**
     * Cria uma nova entrega
     */
    public function firstOrCreate(array $data): Delivery
    {
        return Delivery::query()->firstOrCreate($data);
    }

    public function findByRecipientCpf(string $cpf): ?Collection
    {
        return Delivery::query()->with([
            'carrier',
            'sender',
            'recipient',
            'shippingAddress',
            'statuses',
        ])->whereHas('recipient', function (Builder $query) use ($cpf): void {
            $query->where('cpf', $cpf);
        })->get();
    }
}
