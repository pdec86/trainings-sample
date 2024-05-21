<?php

namespace App\Trainings\Application\Payload;

class TrainingTermDTO
{
    public ?string $id = null;

    public readonly string $dateAndTime;

    public readonly string $price;

    /**
     * @param string $dateAndTime
     * @param string $price
     */
    public function __construct(string $dateAndTime, string $price)
    {
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

    public function getDateAndTime(): string
    {
        return $this->dateAndTime;
    }

    public function getPrice(): string
    {
        return $this->price;
    }
}
