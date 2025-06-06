<?php

namespace App\Repository;

use App\Models\Carrier;
use App\Repository\Contracts\CarrierRepositoryInterface;

class CarrierRepository implements CarrierRepositoryInterface
{

    /**
     * Busca a transportadora pelo UUID
     *
     * @param string $uuid
     * @return Carrier|null
     */
    public function findByUuid(string $uuid): ?Carrier
    {
        return Carrier::query()->where('uuid', $uuid)->first();
    }

    public function create(array $carrierToCreate): Carrier
    {
        return  Carrier::query()->create($carrierToCreate);
    }
}
