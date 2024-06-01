<?php

namespace App\Trainings\Domain\Model\DTO;

class TrainingTermDTO
{
    public readonly string $id;

    public readonly string $dateAndTime;

    public readonly string $price;

    /**
     * @param string $id
     * @param string $dateAndTime
     * @param string $price
     */
    public function __construct(string $id, string $dateAndTime, string $price)
    {
        $this->id = $id;
        $this->dateAndTime = $dateAndTime;
        $this->price = $price;
    }
}
