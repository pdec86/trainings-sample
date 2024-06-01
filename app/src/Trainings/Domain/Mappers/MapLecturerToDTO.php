<?php

namespace App\Trainings\Domain\Mappers;

use App\Trainings\Domain\Model\DTO\LecturerDTO;
use App\Trainings\Domain\Model\Lecturer;
use App\Trainings\Domain\Model\Training;

class MapLecturerToDTO
{
    public function __construct(
        private readonly MapTrainingToDTO $trainingMapper
    ) {
    }

    /**
     * @param Lecturer $lecturer
     * @param Training[] $trainings
     *
     * @return LecturerDTO
     */
    public function mapToDTO(Lecturer $lecturer, array $trainings): LecturerDTO
    {
        return new LecturerDTO(
            $lecturer->getId(),
            $lecturer->getFirstName(),
            $lecturer->getLastName(),
            array_map(function (Training $training) {
                return $this->trainingMapper->mapToDTO($training);
            }, $trainings)
        );
    }
}