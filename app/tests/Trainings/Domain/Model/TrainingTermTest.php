<?php

namespace App\Tests\Trainings\Domain\Model;

use App\Trainings\Domain\Model\Exceptions\DateTimeInPastException;
use App\Trainings\Domain\Model\Exceptions\InvalidPriceException;
use App\Trainings\Domain\Model\Lecturer;
use App\Trainings\Domain\Model\Training;
use App\Trainings\Domain\Model\TrainingTerm;
use App\Trainings\Domain\Traits\BCMathExtendedTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Clock\Test\ClockSensitiveTrait;

class TrainingTermTest extends TestCase
{
    use ClockSensitiveTrait;
    use BCMathExtendedTrait;

    public function testInvalidDateInPast()
    {
        self::expectException(DateTimeInPastException::class);
        self::expectExceptionMessage('Date and time in past. Must be in future');
        $clock = static::mockTime('2022-01-10 15:20:00');
        new TrainingTerm($this->getTraining(), new \DateTimeImmutable('2022-01-10 15:19:59'), '0.00');
    }

    public function testInvalidPriceWithComma()
    {
        self::expectException(InvalidPriceException::class);
        self::expectExceptionMessage('Invalid price provided');
        $clock = static::mockTime('2022-01-10 15:20:00');
        new TrainingTerm($this->getTraining(), new \DateTimeImmutable('2022-01-10 15:21:59'), '100,10');
    }

    public function testInvalidPrice()
    {
        self::expectException(InvalidPriceException::class);
        self::expectExceptionMessage('Invalid price provided');
        $clock = static::mockTime('2022-01-10 15:20:00');
        new TrainingTerm($this->getTraining(), new \DateTimeImmutable('2022-01-10 15:21:59'), 'a.10');
    }

    public function testNegativePrice()
    {
        self::expectException(InvalidPriceException::class);
        self::expectExceptionMessage('Price must be greater or equal 0');
        $clock = static::mockTime('2022-01-10 15:20:00');
        new TrainingTerm($this->getTraining(), new \DateTimeImmutable('2022-01-10 15:21:00'), '-0.01');
    }

    public function testCorrectTrainingTerm()
    {
        $clock = static::mockTime('2022-01-10 15:20:00');

        $term1 = new TrainingTerm($this->getTraining(), new \DateTimeImmutable('2022-01-10 15:21:00'), '0.01');
        self::assertEquals('2022-01-10 15:21:00', $term1->getDateTime()->format('Y-m-d H:i:s'));
        self::assertEquals('0.01', $term1->getPrice());

        $term2 = new TrainingTerm($this->getTraining(), new \DateTimeImmutable('2022-01-11 15:21:00'), '100.01');
        self::assertEquals('2022-01-11 15:21:00', $term2->getDateTime()->format('Y-m-d H:i:s'));
        self::assertEquals('100.01', $term2->getPrice());

        $term3 = new TrainingTerm($this->getTraining(), new \DateTimeImmutable('2022-01-10 15:21:00'), '0.00');
        self::assertEquals('2022-01-10 15:21:00', $term3->getDateTime()->format('Y-m-d H:i:s'));
        self::assertEquals('0.00', $term3->getPrice());
    }

    private function getTraining(): Training
    {
        return Training::createWithSingleTerm(
            'Test training',
            new Lecturer('Jan', 'Kowalski'),
            new \DateTimeImmutable('+1 hour'),
            '100.10'
        );
    }
}
