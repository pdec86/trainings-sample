<?php

namespace App\Trainings\Domain\Services;

use App\Trainings\Domain\Interfaces\CalculateRebateServiceInterface;
use App\Trainings\Domain\Interfaces\RebateServiceInterface;
use App\Trainings\Domain\Model\TrainingTerm;
use App\Trainings\Domain\Traits\BCMathExtendedTrait;

class CalculateRebateService implements CalculateRebateServiceInterface
{
    use BCMathExtendedTrait;

    public function __construct(
        private readonly RebateServiceInterface $rebateService,
    )
    {
    }

    public function getPriceAfterRebate(TrainingTerm $trainingTerm): string
    {
        $rebate = $this->rebateService->getRebate($trainingTerm->getId());

        return $this->bcround(
            \bcmul(
                (100 - min(100, $rebate)) / 100,
                $trainingTerm->getPrice(),
                4),
            2
        );
    }
}