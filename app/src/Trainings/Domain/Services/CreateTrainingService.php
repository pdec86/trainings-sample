<?php

namespace App\Trainings\Domain\Services;

use App\Trainings\Domain\Model\Exceptions\LecturerNotFoundException;
use App\Trainings\Domain\Model\Lecturer;
use App\Trainings\Domain\Model\Training;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class CreateTrainingService
{
    public function __construct(
        private readonly ManagerRegistry $doctrine
    ) {
    }

    /**
     * @param string $name
     * @param string $lecturerId
     * @param \DateTimeImmutable $dateAndTime
     * @param string $price
     *
     * @return Training
     */
    public function execute(
        string $name,
        string $lecturerId,
        \DateTimeImmutable $dateAndTime,
        string $price
    ): Training {
        /** @var EntityManagerInterface $em */
        $em = $this->doctrine->getManager($this->doctrine->getDefaultManagerName());
        $lecturerRepository = $em->getRepository(Lecturer::class);

        $lecturer = $lecturerRepository->findOneBy(['id' => $lecturerId]);
        if (null === $lecturer) {
            throw new LecturerNotFoundException('Lecturer not found');
        }

        $training = Training::createWithSingleTerm($name, $lecturer, $dateAndTime, $price);
        $em->persist($training);
        $em->flush();

        return $training;
    }
}
