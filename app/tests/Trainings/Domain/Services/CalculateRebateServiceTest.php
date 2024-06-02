<?php

namespace App\Tests\Trainings\Domain\Services;

use App\Trainings\Domain\Interfaces\CalculateRebateServiceInterface;
use App\Trainings\Domain\Model\Training;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculateRebateServiceTest extends KernelTestCase
{
    private static CalculateRebateServiceInterface $calculateRebateService;
    private static ManagerRegistry $doctrine;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        static::$calculateRebateService = $container->get(CalculateRebateServiceInterface::class);
        static::$doctrine = $container->get(ManagerRegistry::class);
    }
    public function testGetPriceAfterRebate()
    {
        $em = static::$doctrine->getManager(static::$doctrine->getDefaultManagerName());
        $trainingRepository = $em->getRepository(Training::class);
        $training = $trainingRepository->findOneBy(['name' => 'Training 1']);
        $trainingTerms = $training->getTrainingTerms();
        $trainingTerm = $trainingTerms[0];

        self::assertEquals('100.10', $trainingTerm->getPrice());
        $priceAfterRebate = static::$calculateRebateService->getPriceAfterRebate($trainingTerm);
        self::assertEquals('90.09', $priceAfterRebate);
    }
}
