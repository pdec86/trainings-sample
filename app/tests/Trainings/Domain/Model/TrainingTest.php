<?php

namespace App\Tests\Trainings\Domain\Model;

use App\Trainings\Domain\Model\Exceptions\NameEmptyException;
use App\Trainings\Domain\Model\Exceptions\NameTooLongException;
use App\Trainings\Domain\Model\Lecturer;
use App\Trainings\Domain\Model\Training;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Clock\Test\ClockSensitiveTrait;

class TrainingTest extends TestCase
{
    use ClockSensitiveTrait;

    public function testMaxNameExceeded()
    {
        self::expectException(NameTooLongException::class);
        self::expectExceptionMessage('Provided name is too long');

        $clock = static::mockTime('2022-01-10 15:20:00');

        $name = '';
        for ($i = 0; $i <= 512; $i++) {
            $name .= chr(random_int(65, 90));
        }

        self::assertEquals(513, strlen($name));
        Training::createWithSingleTerm(
            $name,
            new Lecturer('Jan', 'Kowalski'),
            new \DateTimeImmutable('2022-01-10 15:21:00'),
            '0.01'
        );
    }

    public function testNameEmpty()
    {
        self::expectException(NameEmptyException::class);
        self::expectExceptionMessage('Provided name is empty');

        $clock = static::mockTime('2022-01-10 15:20:00');

        Training::createWithSingleTerm(
            '',
            new Lecturer('Jan', 'Kowalski'),
            new \DateTimeImmutable('2022-01-10 15:21:00'),
            '0.01'
        );
    }

    public function testMaxNameValid()
    {
        $clock = static::mockTime('2022-01-10 15:20:00');

        $name = '';
        for ($i = 0; $i < 511; $i++) {
            $name .= chr(random_int(65, 90));
        }
        $name .= 'Ł';

        self::assertEquals(512, mb_strlen($name));
        $training = Training::createWithSingleTerm(
            $name,
            new Lecturer('Jan', 'Kowalski'),
            new \DateTimeImmutable('2022-01-10 15:21:00'),
            '0.01'
        );
        self::assertEquals($name, $training->getName());
    }
}
