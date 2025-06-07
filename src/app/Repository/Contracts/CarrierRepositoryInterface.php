<?php

namespace App\Repository\Contracts;

use App\Models\Carrier;

interface CarrierRepositoryInterface
{
    public function firstOrCreate(array $carrierToCreate): Carrier;
}
