<?php

namespace App\Http\Controllers;

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
        $cpfToSearch = $request->get('search_term');
        $foundDeliveries = collect();

        if ($cpfToSearch) {
            try {
                $foundDeliveries = $this->trackingService->findOrCreateDeliveriesByCpf($cpfToSearch);
            } catch (\Exception $e) {
                Log::error('Error during delivery search: ' . $e->getMessage());
            }
        }

        return view('tracking.index', [
            'searchTerm' => $cpfToSearch,
            'foundDeliveries' => $foundDeliveries,
        ]);
    }
}
