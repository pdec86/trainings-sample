<?php

namespace App\Trainings\Application\Services;

use App\Trainings\Application\Mappers\MapTrainingToDTO;
use App\Trainings\Application\Payload\TrainingDTO;
use App\Trainings\Domain\Model\Training;
use App\Trainings\Domain\Services\CreateTrainingService;
use App\Trainings\Domain\Services\UpdateTrainingService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class TrainingManager
{
    public function __construct(
        private readonly ManagerRegistry $doctrine,
        private readonly CreateTrainingService $createTrainingService,
        private readonly UpdateTrainingService $updateTrainingService,
        private readonly MapTrainingToDTO $mapTrainingToDTO,
    )
    {
    }

    public function createTraining(TrainingDTO $trainingDTO): void
    {
        $this->createTrainingService->execute(
            $trainingDTO->getName(),
            $trainingDTO->getLecturerFirstName(),
            $trainingDTO->getLecturerLastName(),
            new \DateTimeImmutable($trainingDTO->getDateAndTime()),
            $trainingDTO->getPrice()
        );
    }

    public function updateTraining(
        string $trainingId,
        TrainingDTO $trainingDTO
    ): void {
        $this->updateTrainingService->execute(
            $trainingId,
            $trainingDTO->getName(),
            $trainingDTO->getLecturerFirstName(),
            $trainingDTO->getLecturerLastName(),
            $trainingDTO->getTrainingTermId(),
            new \DateTimeImmutable($trainingDTO->getDateAndTime()),
            $trainingDTO->getPrice()
        );
    }

    public function getTraining(
        string $trainingId
    ): TrainingDTO {
        /** @var EntityManagerInterface $em */
        $em = $this->doctrine->getManager($this->doctrine->getDefaultManagerName());
        $trainingRepository = $em->getRepository(Training::class);

        $training = $trainingRepository->findOneBy(['id' => $trainingId]);
        if (null === $training) {
            throw new \RuntimeException('Training not found');
        }

        return $this->mapTrainingToDTO->mapToDTO($training);
    }

    /**
     * @param string|null $trainingName
     * @param string|null $trainingTermDate
     * @param string|null $trainingLecturer
     *
     * @return TrainingDTO[]
     */
    public function getTrainingList(
        ?string $trainingName = null,
        ?string $trainingTermDate = null,
        ?string $trainingLecturer = null
    ): array {
        /** @var EntityManagerInterface $em */
        $em = $this->doctrine->getManager($this->doctrine->getDefaultManagerName());
        $trainingRepository = $em->getRepository(Training::class);

        /** @var Training[] $trainings */
        $trainings = $trainingRepository->fetchList($trainingName, $trainingLecturer, $trainingTermDate);

        return array_map([$this->mapTrainingToDTO, 'mapToDTO'], $trainings);
    }

    public function getTrainingCount(string $date): int
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            throw new \DomainException('Invalid date provided');
        }

        /** @var EntityManagerInterface $em */
        $em = $this->doctrine->getManager($this->doctrine->getDefaultManagerName());
        $trainingRepository = $em->getRepository(Training::class);

        /** @var Training[] $trainings */
        return $trainingRepository->fetchCountForDate($date);
    }

    public function deleteTraining(
        string $trainingId
    ): void {
        /** @var EntityManagerInterface $em */
        $em = $this->doctrine->getManager($this->doctrine->getDefaultManagerName());
        $trainingRepository = $em->getRepository(Training::class);

        $training = $trainingRepository->findOneBy(['id' => $trainingId]);
        if (null === $training) {
            throw new \RuntimeException('Training not found');
        }

        $em->remove($training);
        $em->flush();
    }
}
