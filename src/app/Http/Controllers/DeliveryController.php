<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\ApiServiceInterface;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    protected ApiServiceInterface $apiService;

    public function __construct(ApiServiceInterface $apiService)
    {
        $this->apiService = $apiService;
    }
    public function index()
    {
       return $this->apiService->fetchAllCarriers();
    }
}
