<?php

namespace App\Trainings\Application\Payload;

class UpdateTrainingPayload
{
    public readonly string $name;

    public readonly string $lecturerId;

    /**
     * @param string $name
     * @param string $lecturerId
     */
    public function __construct(
        string $name,
        string $lecturerId,
    ) {
        $this->name = $name;
        $this->lecturerId = $lecturerId;
    }
}
