<?php

namespace App\Repository\Contracts;

use App\Models\Delivery;
use Illuminate\Support\Collection;

interface DeliveryRepositoryInterface
{
    public function firstOrCreate(array $data): Delivery;

    public function findByRecipientCpf(string $cpf): ?Collection;
}
