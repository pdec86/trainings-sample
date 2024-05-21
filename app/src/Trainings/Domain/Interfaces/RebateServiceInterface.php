<?php

namespace App\Trainings\Domain\Interfaces;

interface RebateServiceInterface
{
    public function getRebate($trainingTermId): int;
}
