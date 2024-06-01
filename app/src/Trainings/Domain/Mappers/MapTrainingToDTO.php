<?php

namespace App\Trainings\Domain\Mappers;

use App\Trainings\Domain\Model\DTO\TrainingDTO;
use App\Trainings\Domain\Model\Training;
use App\Trainings\Domain\Model\TrainingTerm;

class MapTrainingToDTO
{
    public function __construct(
        private readonly MapTrainingTermToDTO $trainingTermMapper,
    )
    {

    }
    public function mapToDTO(Training $training): TrainingDTO
    {
        return new TrainingDTO(
            $training->getId(),
            $training->getName(),
            $training->getLecturer()->getFirstName(),
            $training->getLecturer()->getLastName(),
            array_map(function (TrainingTerm $trainingTerm) {
                return $this->trainingTermMapper->mapToDTO($trainingTerm);
            }, $training->getTrainingTerms())
        );
    }
}