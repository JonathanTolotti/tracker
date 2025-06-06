<?php

namespace App\Repository\Contracts;

use App\Models\Delivery;
use Illuminate\Support\Collection;

interface DeliveryRepositoryInterface
{
    public function findByUuid(string $uuid): ?Delivery;

    public function findByRecipientId(int $recipientId): Collection;

    public function create(array $data): Delivery;

}
