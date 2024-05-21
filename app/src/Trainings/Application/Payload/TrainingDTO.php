<?php

namespace App\Trainings\Application\Payload;

use Symfony\Component\Serializer\Attribute\Ignore;

class TrainingDTO
{
    public ?string $id = null;

    public readonly string $name;

    public readonly string $lecturerFirstName;

    public readonly string $lecturerLastName;

    public ?string $trainingTermId = null;

    public readonly ?string $dateAndTime;

    public readonly ?string $price;

    public array $trainingTerms = [];

    /**
     * @param string $name
     * @param string $lecturerFirstName
     * @param string $lecturerLastName
     * @param string|null $dateAndTime
     * @param string|null $price
     */
    public function __construct(string $name, string $lecturerFirstName, string $lecturerLastName, ?string $dateAndTime = null, ?string $price = null)
    {
        $this->name = $name;
        $this->lecturerFirstName = $lecturerFirstName;
        $this->lecturerLastName = $lecturerLastName;
        $this->dateAndTime = $dateAndTime;
        $this->price = $price;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLecturerFirstName(): string
    {
        return $this->lecturerFirstName;
    }

    public function getLecturerLastName(): string
    {
        return $this->lecturerLastName;
    }

    public function getDateAndTime(): string
    {
        return $this->dateAndTime;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getTrainingTermId(): ?string
    {
        return $this->trainingTermId;
    }

    public function setTrainingTerms(array $trainingTerms): void
    {
        $this->trainingTerms = $trainingTerms;
    }
}
