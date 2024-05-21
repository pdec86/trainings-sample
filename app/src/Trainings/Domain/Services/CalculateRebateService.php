<?php

namespace App\Trainings\Domain\Services;

use App\Trainings\Domain\Interfaces\RebateServiceInterface;
use App\Trainings\Domain\Model\TrainingTerm;

class CalculateRebateService
{
    public function __construct(
        private readonly RebateServiceInterface $rebateService,
    )
    {
    }

    public function calculateRebate(TrainingTerm $trainingTerm): string
    {
        $rebate = $this->rebateService->getRebate($trainingTerm->getId());

        return \bcmul((100 - min(100, $rebate)) / 100, $trainingTerm->getPrice(), 2);
    }
}