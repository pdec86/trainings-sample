<?php

namespace App\Trainings\Domain\Mappers;

use App\Trainings\Domain\Interfaces\CalculateRebateServiceInterface;
use App\Trainings\Domain\Model\DTO\TrainingTermDTO;
use App\Trainings\Domain\Model\TrainingTerm;

class MapTrainingTermToDTO
{
    public function __construct(
        private readonly CalculateRebateServiceInterface $rebateService
    )
    {
    }

    public function mapToDTO(TrainingTerm $trainingTerm): TrainingTermDTO
    {
        return new TrainingTermDTO(
            $trainingTerm->getId(),
            $trainingTerm->getDateTime()->format('Y-m-d H:i:s'),
            $this->rebateService->getPriceAfterRebate($trainingTerm)
        );
    }
}