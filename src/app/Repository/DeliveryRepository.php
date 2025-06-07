<?php

namespace App\Repository;

use App\Models\Delivery;
use App\Models\Recipient;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DeliveryRepository
{
    /**
     * Cria uma nova entrega
     *
     * @param array $data
     * @return Delivery
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
            'statuses'
        ])->whereHas('recipient', function (Builder $query) use ($cpf) {
            $query->where('cpf', $cpf);
        })->get();
    }
}
