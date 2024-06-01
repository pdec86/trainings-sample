<?php

namespace App\Trainings\Domain\Model;

use App\Trainings\Domain\Model\Exceptions\NameEmptyException;
use App\Trainings\Domain\Model\Exceptions\NameTooLongException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'app_lecturer')]
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
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        if (mb_strlen($firstName) > 256) {
            throw new NameTooLongException('Provided first name is too long');
        }
        if (mb_strlen($firstName) == 0) {
            throw new NameEmptyException('Provided first name is empty');
        }

        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        if (mb_strlen($lastName) > 256) {
            throw new NameTooLongException('Provided last name is too long');
        }
        if (mb_strlen($lastName) == 0) {
            throw new NameEmptyException('Provided last name is empty');
        }

        $this->lastName = $lastName;
    }
}