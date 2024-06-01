<?php

namespace App\Tests\Trainings\Domain\Services;

use App\Trainings\Domain\Model\Lecturer;
use App\Trainings\Domain\Services\CreateLecturerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateLecturerServiceTest extends KernelTestCase
{
    private static CreateLecturerService $createLecturerService;
    private static ManagerRegistry $doctrine;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        static::$createLecturerService = $container->get(CreateLecturerService::class);
        static::$doctrine = $container->get(ManagerRegistry::class);
    }

    public function testCreateValidLecturer()
    {
        $lecturer = self::$createLecturerService->execute('Jan', 'Nowak');
        self::assertEquals('Jan', $lecturer->getFirstName());
        self::assertEquals('Nowak', $lecturer->getLastName());

        $em = static::$doctrine->getManager(static::$doctrine->getDefaultManagerName());
        $repository = $em->getRepository(Lecturer::class);

        $lecturerFromDb = $repository->findOneBy(['id' => $lecturer->getId()]);
        self::assertInstanceOf(Lecturer::class, $lecturerFromDb);
        self::assertEquals($lecturer->getId(), $lecturerFromDb->getId());
        self::assertEquals($lecturer->getFirstName(), $lecturerFromDb->getFirstName());
        self::assertEquals($lecturer->getLastName(), $lecturerFromDb->getLastName());
    }
}
