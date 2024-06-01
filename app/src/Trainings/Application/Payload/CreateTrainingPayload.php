<?php

namespace App\Trainings\Application\Payload;

class CreateTrainingPayload
{
    public readonly string $name;

    public readonly string $lecturerId;

    public readonly \DateTimeImmutable $dateAndTime;

    public readonly string $price;

    /**
     * @param string $name
     * @param string $lecturerId
     * @param string $dateAndTime
     * @param string $price
     */
    public function __construct(
        string $name,
        string $lecturerId,
        string $dateAndTime,
        string $price
    ) {
        $this->name = $name;
        $this->lecturerId = $lecturerId;
        $this->dateAndTime = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dateAndTime);
        $this->price = $price;
    }
}
