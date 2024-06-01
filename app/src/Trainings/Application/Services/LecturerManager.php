<?php

namespace App\Trainings\Application\Services;

use App\Trainings\Application\Payload\CreateLecturerPayload;
use App\Trainings\Domain\Mappers\MapLecturerToDTO;
use App\Trainings\Domain\Model\DTO\LecturerDTO;
use App\Trainings\Domain\Model\Exceptions\LecturerNotFoundException;
use App\Trainings\Domain\Model\Lecturer;
use App\Trainings\Domain\Model\Training;
use App\Trainings\Domain\Services\CreateLecturerService;
use App\Trainings\Infrastructure\Repository\TrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class LecturerManager
{
    public function __construct(
        private readonly ManagerRegistry $doctrine,
        private readonly CreateLecturerService $createLecturerService,
        private readonly MapLecturerToDTO $lecturerMapper,
    )
    {
    }

    public function createLecturer(CreateLecturerPayload $payload): LecturerDTO
    {
        $lecturer = $this->createLecturerService->execute(
            $payload->firstName,
            $payload->lastName
        );

        return $this->lecturerMapper->mapToDTO($lecturer, []);
    }

    public function getLecturer(
        string $lecturerId
    ): LecturerDTO {
        /** @var EntityManagerInterface $em */
        $em = $this->doctrine->getManager($this->doctrine->getDefaultManagerName());
        $lecturerRepository = $em->getRepository(Lecturer::class);

        $lecturer = $lecturerRepository->findOneBy(['id' => $lecturerId]);
        if (null === $lecturer) {
            throw new LecturerNotFoundException('Lecturer not found');
        }

        return $this->lecturerMapper->mapToDTO($lecturer, []);
    }

    public function getLecturerWithTrainings(
        string $lecturerId
    ): LecturerDTO {
        /** @var EntityManagerInterface $em */
        $em = $this->doctrine->getManager($this->doctrine->getDefaultManagerName());
        $lecturerRepository = $em->getRepository(Lecturer::class);
        /** @var TrainingRepository $trainingRepository */
        $trainingRepository = $em->getRepository(Training::class);

        $lecturer = $lecturerRepository->findOneBy(['id' => $lecturerId]);
        if (null === $lecturer) {
            throw new LecturerNotFoundException('Lecturer not found');
        }

        return $this->lecturerMapper->mapToDTO(
            $lecturer,
            $trainingRepository->fetchListByLecturer($lecturer->getId())
        );
    }
}
