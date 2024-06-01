<?php

namespace App\Trainings\Domain\Model\DTO;

class TrainingDTO
{
    public readonly string $id;

    public readonly string $name;

    public readonly string $lecturerFirstName;

    public readonly string $lecturerLastName;

    /**
     * @var TrainingTermDTO[]
     */
    public readonly array $trainingTerms;

    /**
     * @param string $id
     * @param string $name
     * @param string $lecturerFirstName
     * @param string $lecturerLastName
     * @param array $trainingTerms
     */
    public function __construct(
        string $id,
        string $name,
        string $lecturerFirstName,
        string $lecturerLastName,
        array $trainingTerms
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->lecturerFirstName = $lecturerFirstName;
        $this->lecturerLastName = $lecturerLastName;

        foreach ($trainingTerms as $trainingTerm) {
            if (!($trainingTerm instanceof TrainingTermDTO)) {
                throw new \LogicException('Training term not of proper class.');
            }
        }
        $this->trainingTerms = $trainingTerms;
    }
}
