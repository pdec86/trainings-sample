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
                \bcdiv(\bcsub('100', (string) min(100, $rebate), 4), '100', 4),
                $trainingTerm->getPrice(),
                4),
            2
        );
    }
}