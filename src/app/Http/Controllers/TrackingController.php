<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Services\TrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TrackingController extends Controller
{
    protected TrackingService $trackingService;

    public function __construct(TrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    public function index(Request $request): View
    {
        $cpfToSearch = $request->get('cpf');
        $foundDeliveries = collect();

        if ($cpfToSearch) {
            try {
                $foundDeliveries = $this->trackingService->findOrCreateDeliveriesByCpf($cpfToSearch);
            } catch (\Exception $e) {
                Log::error('Erro ao realizar a busca: '.$e->getMessage());
            }
        }

        return view('tracking.index', [
            'searchTerm' => $cpfToSearch,
            'foundDeliveries' => $foundDeliveries,
        ]);
    }

    public function show(Delivery $delivery): View
    {
        $delivery->load(['carrier', 'sender', 'recipient', 'shippingAddress', 'statuses']);

        return view('tracking.show', [
            'detailedDelivery' => $delivery,
        ]);

    }
}
