<?php

namespace App\Trainings\Domain\Interfaces;

use App\Trainings\Domain\Model\TrainingTerm;

interface CalculateRebateServiceInterface
{
    public function getPriceAfterRebate(TrainingTerm $trainingTerm): string;
}
