<?php

namespace App\Trainings\Domain\Services;

use App\Trainings\Domain\Model\Exceptions\LecturerNotFoundException;
use App\Trainings\Domain\Model\Exceptions\TrainingNotFoundException;
use App\Trainings\Domain\Model\Lecturer;
use App\Trainings\Domain\Model\Training;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class UpdateTrainingService
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
        string $trainingId,
        string $name,
        string $lecturerId,
    ): Training {
        if (!preg_match('/^\d+$/', $trainingId)) {
            throw new \RuntimeException('Invalid training ID');
        }

        /** @var EntityManagerInterface $em */
        $em = $this->doctrine->getManager($this->doctrine->getDefaultManagerName());
        $lecturerRepository = $em->getRepository(Lecturer::class);
        $trainingRepository = $em->getRepository(Training::class);

        $em->getConnection()->beginTransaction();

        try {
            $training = $trainingRepository->find($trainingId, LockMode::PESSIMISTIC_WRITE);
            if (null === $training) {
                throw new TrainingNotFoundException('Training not found');
            }

            $lecturer = $lecturerRepository->find($lecturerId);
            if (null === $lecturer) {
                throw new LecturerNotFoundException('Lecturer not found');
            }

            $training->changeName($name);
            $training->changeLecturer($lecturer);

            $em->persist($training);

            $em->flush();
            $em->getConnection()->commit();

            return $training;
        } catch (\Throwable $throwable) {
            $em->getConnection()->rollBack();
            throw $throwable;
        }
    }
}
