<?php

namespace App\Trainings\Application\Mappers;

use App\Trainings\Application\Payload\TrainingDTO;
use App\Trainings\Application\Payload\TrainingTermDTO;
use App\Trainings\Domain\Model\Training;
use App\Trainings\Domain\Model\TrainingTerm;
use App\Trainings\Domain\Services\CalculateRebateService;

class MapTrainingToDTO
{
    public function __construct(
        private readonly CalculateRebateService $calculateRebateService,
    )
    {
    }

    public function mapToDTO(Training $training): TrainingDTO
    {
        $trainingDTO = new TrainingDTO(
            $training->getName(),
            $training->getLecturer()->getFirstName(),
            $training->getLecturer()->getLastName()
        );
        $trainingDTO->setId($training->getId());
        $trainingDTO->setTrainingTerms(array_map(function (TrainingTerm $trainingTerm) {
            $trainingTermDTO = new TrainingTermDTO(
                $trainingTerm->getDateTime()->format('Y-m-d H:i:s'),
                $this->calculateRebateService->calculateRebate($trainingTerm)
            );

            $trainingTermDTO->setId($trainingTerm->getId());

            return $trainingTermDTO;
        }, $training->getTrainingTerms()));

        return $trainingDTO;
    }
}