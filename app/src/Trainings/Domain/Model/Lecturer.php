<?php

namespace App\Trainings\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'app_lecturer', schema: 'simpleDb')]
#[ORM\Entity()]
class Lecturer
{
    #[ORM\Column(name: 'id', type: 'bigint')]
    #[ORM\GeneratedValue()]
    #[ORM\Id]
    private string $id;

    #[ORM\Column(name: 'firstName', type: 'string', length: 256, nullable: false)]
    private string $firstName;

    #[ORM\Column(name: 'lastName', type: 'string', length: 256, nullable: false)]
    private string $lastName;

    /**
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(string $firstName, string $lastName)
    {
        if (mb_strlen($firstName) > 256) {
            throw new \DomainException('Provided first name is too long');
        }
        if (mb_strlen($firstName) == 0) {
            throw new \DomainException('Provided first name is empty');
        }

        if (mb_strlen($lastName) > 256) {
            throw new \DomainException('Provided last name is too long');
        }
        if (mb_strlen($lastName) == 0) {
            throw new \DomainException('Provided last name is empty');
        }

        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}