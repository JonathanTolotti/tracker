<?php

namespace App\Services;

use App\Models\Delivery;
use Illuminate\Support\Collection;

class TrackingService
{
    protected CarrierService $carrierService;
    protected RecipientService $recipientService;

    protected DeliveryService $deliveryService;

    public function __construct(
        CarrierService $carrierService,
        RecipientService $recipientService,
        DeliveryService $deliveryService
    )
    {
        $this->carrierService = $carrierService;
        $this->recipientService = $recipientService;
        $this->deliveryService = $deliveryService;
    }

    public function findOrCreateDeliveriesByCpf(string $cpf): Collection
    {
        $deliveries = $this->deliveryService->getDeliveryByCpf($cpf);

        if ($deliveries->isEmpty()) {
            return $this->deliveryService->createDelivery($cpf);
        }

        return $deliveries;
    }

}
