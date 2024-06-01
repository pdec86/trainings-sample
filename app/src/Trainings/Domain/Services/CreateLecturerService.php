<?php

namespace App\Trainings\Domain\Services;

use App\Trainings\Domain\Model\Lecturer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class CreateLecturerService
{
    public function __construct(
        private readonly ManagerRegistry $doctrine
    ) {
    }

    /**
     * @param string $lecturerFirstName
     * @param string $lecturerLastName
     *
     * @return Lecturer
     */
    public function execute(
        string $lecturerFirstName,
        string $lecturerLastName
    ): Lecturer {
        /** @var EntityManagerInterface $em */
        $em = $this->doctrine->getManager($this->doctrine->getDefaultManagerName());

        $lecturer = new Lecturer($lecturerFirstName, $lecturerLastName);
        $em->persist($lecturer);
        $em->flush();

        return $lecturer;
    }
}