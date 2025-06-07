<?php

namespace App\Services;

use App\Models\Carrier;
use App\Repository\CarrierRepository;
use App\Services\Contracts\ApiServiceInterface;

class CarrierService
{
    protected CarrierRepository $carrierRepository;

    protected ApiServiceInterface $apiService;

    public function __construct(
        CarrierRepository $carrierRepository,
        ApiServiceInterface $apiService
    ) {
        $this->carrierRepository = $carrierRepository;
        $this->apiService = $apiService;
    }

    public function findOrCreate(string $uuid): Carrier
    {
        $carrier = $this->apiService->findCarrierById($uuid);

        return $this->carrierRepository->firstOrCreate($carrier->first());
    }
}
