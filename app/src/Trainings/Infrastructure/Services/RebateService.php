<?php

namespace App\Trainings\Infrastructure\Services;

use App\Trainings\Domain\Interfaces\RebateServiceInterface;

class RebateService implements RebateServiceInterface
{
    public function getRebate($trainingTermId): int
    {
        return 10;
    }
}