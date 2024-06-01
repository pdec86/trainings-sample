<?php

namespace App\Trainings\Domain\Model\DTO;

class LecturerDTO
{
    public readonly string $id;

    public readonly string $firstName;

    public readonly string $lastName;

    /**
     * @var TrainingDTO[]
     */
    public readonly array $trainings;

    /**
     * @param string $id
     * @param string $firstName
     * @param string $lastName
     * @param TrainingDTO[]|null $trainings
     */
    public function __construct(string $id, string $firstName, string $lastName, array $trainings = null)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->trainings = $trainings;

        foreach ($this->trainings as $training) {
            if (!($training instanceof TrainingDTO)) {
                throw new \LogicException('Training not of proper class.');
            }
        }
    }
}
