<?php

namespace App\Repository\Contracts;

use App\Models\Carrier;

interface CarrierRepositoryInterface
{
    public function findByUuid(string $uuid): ?Carrier;

    public function create(array $carrierToCreate): Carrier;
}
