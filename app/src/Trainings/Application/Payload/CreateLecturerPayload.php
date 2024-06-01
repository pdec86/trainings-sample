<?php

namespace App\Trainings\Application\Payload;

class CreateLecturerPayload
{
    public readonly string $firstName;

    public readonly string $lastName;

    /**
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(
        string $firstName,
        string $lastName
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}
