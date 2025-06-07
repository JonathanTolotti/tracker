<?php

namespace App\Services;

use App\Models\Carrier;
use App\Repository\Contracts\CarrierRepositoryInterface;

class CarrierService
{
    protected CarrierRepositoryInterface $carrierRepository;

    public function __construct(
        CarrierRepositoryInterface $carrierRepository
    ) {
        $this->carrierRepository = $carrierRepository;
    }

    public function firstOrCreate(array $data): Carrier
    {
        return $this->carrierRepository->firstOrCreate($data);
    }
}
