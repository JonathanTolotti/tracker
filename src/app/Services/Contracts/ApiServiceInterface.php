<?php

namespace App\Services\Contracts;

use Illuminate\Support\Collection;

interface ApiServiceInterface
{
    public function fetchAllDeliveries(): Collection;

    public function fetchAllCarriers(): Collection;
}
