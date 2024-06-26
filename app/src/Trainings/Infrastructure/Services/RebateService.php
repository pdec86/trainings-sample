<?php

namespace App\Trainings\Infrastructure\Services;

use App\Trainings\Domain\Interfaces\RebateServiceInterface;

class RebateService implements RebateServiceInterface
{
    public function getRebate(string $trainingTermId): int
    {
        return random_int(0, 99);
    }
}