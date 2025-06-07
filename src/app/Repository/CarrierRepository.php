<?php

namespace App\Repository;

use App\Models\Carrier;
use App\Repository\Contracts\CarrierRepositoryInterface;

class CarrierRepository implements CarrierRepositoryInterface
{
    /**
     * Cria uma nova transportadora
     */
    public function firstOrCreate(array $carrierToCreate): Carrier
    {
        return Carrier::query()->firstOrCreate([
            'uuid' => $carrierToCreate['_id'],
            'name' => $carrierToCreate['_fantasia'],
            'cnpj' => $carrierToCreate['_cnpj'],
        ]);
    }
}
