<?php

namespace App\DataFixtures;

use App\Trainings\Application\Payload\TrainingDTO;
use App\Trainings\Application\Services\TrainingManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly TrainingManager $trainingManager
    )
    {

    }
    public function load(ObjectManager $manager): void
    {
        $this->trainingManager->createTraining(
            new TrainingDTO(
                'Training 1',
                'Jan',
                'Kowalski',
                (new \DateTimeImmutable('+1 hour'))->format('Y-m-d H:i:s'),
                '100.10'
            )
        );

        $this->trainingManager->createTraining(
            new TrainingDTO(
                'Training 2',
                'Jan',
                'Kowalski',
                (new \DateTimeImmutable('+2 days'))->format('Y-m-d H:i:s'),
                '200.02'
            )
        );

        $this->trainingManager->createTraining(
            new TrainingDTO(
                'Training 3',
                'Jan',
                'Kowalski',
                (new \DateTimeImmutable('+1 day'))->format('Y-m-d H:i:s'),
                '100.10'
            )
        );

        $this->trainingManager->createTraining(
            new TrainingDTO(
                'Training 4',
                'Jan',
                'Nowak',
                (new \DateTimeImmutable('+1 hour'))->format('Y-m-d H:i:s'),
                '2000.10'
            )
        );

        $this->trainingManager->createTraining(
            new TrainingDTO(
                'Training 5',
                'Jan',
                'Nowak',
                (new \DateTimeImmutable('+2 days'))->format('Y-m-d H:i:s'),
                '1000.10'
            )
        );

        $manager->flush();
    }
}
