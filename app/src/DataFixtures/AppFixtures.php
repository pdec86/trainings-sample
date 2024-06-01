<?php

namespace App\DataFixtures;

use App\Trainings\Application\Payload\CreateLecturerPayload;
use App\Trainings\Application\Payload\CreateTrainingPayload;
use App\Trainings\Application\Services\LecturerManager;
use App\Trainings\Application\Services\TrainingManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly TrainingManager $trainingManager,
        private readonly LecturerManager $lecturerManager,
    )
    {

    }
    public function load(ObjectManager $manager): void
    {
        $lecturer1 = $this->lecturerManager->createLecturer(
            new CreateLecturerPayload('Jan', 'Nowak')
        );
        $lecturer2 = $this->lecturerManager->createLecturer(
            new CreateLecturerPayload('Jan', 'Kowalski')
        );

        $this->trainingManager->createTraining(
            new CreateTrainingPayload(
                'Training 1',
                $lecturer1->id,
                (new \DateTimeImmutable('+1 hour'))->format('Y-m-d H:i:s'),
                '100.10'
            )
        );

        $this->trainingManager->createTraining(
            new CreateTrainingPayload(
                'Training 2',
                $lecturer2->id,
                (new \DateTimeImmutable('+2 days'))->format('Y-m-d H:i:s'),
                '200.02'
            )
        );

        $this->trainingManager->createTraining(
            new CreateTrainingPayload(
                'Training 3',
                $lecturer2->id,
                (new \DateTimeImmutable('+1 day'))->format('Y-m-d H:i:s'),
                '100.10'
            )
        );

        $this->trainingManager->createTraining(
            new CreateTrainingPayload(
                'Training 4',
                $lecturer1->id,
                (new \DateTimeImmutable('+1 hour'))->format('Y-m-d H:i:s'),
                '2000.10'
            )
        );

        $this->trainingManager->createTraining(
            new CreateTrainingPayload(
                'Training 5',
                $lecturer1->id,
                (new \DateTimeImmutable('+2 days'))->format('Y-m-d H:i:s'),
                '1000.10'
            )
        );

        $manager->flush();
    }
}
