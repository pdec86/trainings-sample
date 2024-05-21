<?php

namespace App\Trainings\Domain\Services;

use App\Trainings\Domain\Model\Lecturer;
use App\Trainings\Domain\Model\Training;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class CreateTrainingService
{
    public function __construct(
        private ManagerRegistry $doctrine
    ) {
    }

    /**
     * @throws \Throwable
     * @throws Exception
     */
    public function execute(
        string $name,
        string $lecturerFirstName,
        string $lecturerLastName,
        \DateTimeImmutable $dateAndTime,
        string $price
    ): void {
        /** @var EntityManagerInterface $em */
        $em = $this->doctrine->getManager($this->doctrine->getDefaultManagerName());
        $lecturerRepository = $em->getRepository(Lecturer::class);

        $em->getConnection()->beginTransaction();

        try {
            $lecturer = $lecturerRepository->findOneBy(['firstName' => $lecturerFirstName, 'lastName' => $lecturerLastName]);
            if (null === $lecturer) {
                $lecturer = new Lecturer($lecturerFirstName, $lecturerLastName);
                $em->persist($lecturer);
            }

            $training = new Training($name, $lecturer, $dateAndTime, $price);
            $em->persist($training);

            $em->flush();
            $em->getConnection()->commit();
        } catch (\Throwable $throwable) {
            $em->getConnection()->rollBack();
            throw $throwable;
        }
    }
}
