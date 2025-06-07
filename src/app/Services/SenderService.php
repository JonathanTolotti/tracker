<?php

namespace App\Services;

use App\Models\Sender;
use App\Repository\SenderRepository;

class SenderService
{
    protected SenderRepository $senderRepository;

    public function __construct(SenderRepository $senderRepository)
    {
        $this->senderRepository = $senderRepository;
    }

    public function findOrCreateByName(string $name): Sender
    {
        $name = trim(ucwords($name));

        return $this->senderRepository->firstOrCreate([
            'name' => $name,
        ]);
    }
}
