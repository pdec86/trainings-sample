<?php

namespace App\Tests\Trainings\Infrastructure\Services;

use App\Trainings\Domain\Interfaces\RebateServiceInterface;

class RebateService implements RebateServiceInterface
{
    public function getRebate(string $trainingTermId): int
    {
        return 10;
    }
}
