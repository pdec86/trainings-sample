<?php

namespace App\Trainings\Domain\Interfaces;

interface RebateServiceInterface
{
    public function getRebate(string $trainingTermId): int;
}
