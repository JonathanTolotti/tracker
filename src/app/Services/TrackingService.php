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

    /**
     * Se a entrega já existir no DB ela é retornada, caso contrário, consultamos a api e criamos.
     *
     * @param string $cpf
     * @return Collection
     */
    public function findOrCreateDeliveriesByCpf(string $cpf): Collection
    {
        $deliveries = $this->deliveryService->getDeliveryByCpf($cpf);

        if ($deliveries->isEmpty()) {
            return $this->deliveryService->createDelivery($cpf);
        }

        return $deliveries;
    }

}
