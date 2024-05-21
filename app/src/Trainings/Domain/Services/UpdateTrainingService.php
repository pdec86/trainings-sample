<?php

namespace App\Trainings\Domain\Services;

use App\Trainings\Domain\Model\Lecturer;
use App\Trainings\Domain\Model\Training;
use Doctrine\DBAL\Exception;
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
        string $lecturerFirstName,
        string $lecturerLastName,
        ?string $trainingTermId = null,
        ?\DateTimeImmutable $dateAndTime = null,
        ?string $price = null
    ): void {
        if (!preg_match('/^\d+$/', $trainingId)) {
            throw new \RuntimeException('Invalid training ID');
        }

        /** @var EntityManagerInterface $em */
        $em = $this->doctrine->getManager($this->doctrine->getDefaultManagerName());
        $lecturerRepository = $em->getRepository(Lecturer::class);
        $trainingRepository = $em->getRepository(Training::class);

        $em->getConnection()->beginTransaction();

        try {
            $training = $trainingRepository->findOneBy(['id' => $trainingId]);
            if (null === $training) {
                throw new \RuntimeException('Training not found');
            }

            $lecturer = $lecturerRepository->findOneBy(['firstName' => $lecturerFirstName, 'lastName' => $lecturerLastName]);
            if (null === $lecturer) {
                $lecturer = new Lecturer($lecturerFirstName, $lecturerLastName);
                $em->persist($lecturer);
            }

            $training->changeName($name);
            $training->changeLecturer($lecturer);

            if (null !== $trainingTermId) {
                $training->changeDateAndTime($trainingTermId, $dateAndTime);
                $training->changePrice($trainingTermId, $price);
            }

            $em->persist($training);

            $em->flush();
            $em->getConnection()->commit();
        } catch (\Throwable $throwable) {
            $em->getConnection()->rollBack();
            throw $throwable;
        }
    }
}
