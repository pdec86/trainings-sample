<?php

namespace App\Tests\Trainings\Domain\Model;

use App\Trainings\Domain\Model\Exceptions\NameEmptyException;
use App\Trainings\Domain\Model\Exceptions\NameTooLongException;
use App\Trainings\Domain\Model\Lecturer;
use PHPUnit\Framework\TestCase;

class LecturerTest extends TestCase
{
    public function testFirstNameTooLong()
    {
        self::expectException(NameTooLongException::class);
        self::expectExceptionMessage('Provided first name is too long');

        $name = '';
        for ($i = 0; $i <= 256; $i++) {
            $name .= chr(random_int(65, 90));
        }

        new Lecturer($name, 'a');
    }

    public function testLastNameTooLong()
    {
        self::expectException(NameTooLongException::class);
        self::expectExceptionMessage('Provided last name is too long');

        $name = '';
        for ($i = 0; $i <= 256; $i++) {
            $name .= chr(random_int(65, 90));
        }

        new Lecturer('a', $name);
    }

    public function testFirstNameEmpty()
    {
        self::expectException(NameEmptyException::class);
        self::expectExceptionMessage('Provided first name is empty');

        $name = '';
        for ($i = 0; $i < 256; $i++) {
            $name .= chr(random_int(65, 90));
        }

        new Lecturer('', $name);
    }

    public function testLastNameEmpty()
    {
        self::expectException(NameEmptyException::class);
        self::expectExceptionMessage('Provided last name is empty');

        $name = '';
        for ($i = 0; $i < 256; $i++) {
            $name .= chr(random_int(65, 90));
        }

        new Lecturer($name, '');
    }

    public function testMaxNameValid()
    {
        $firstName = '';
        for ($i = 0; $i < 251; $i++) {
            $firstName .= chr(random_int(65, 90));
        }
        $firstName .= 'Ó';

        $lastName = '';
        for ($i = 0; $i < 255; $i++) {
            $lastName .= chr(random_int(65, 90));
        }
        $lastName .= 'Ę';

        $lecturer = new Lecturer($firstName, $lastName);
        self::assertEquals($firstName, $lecturer->getFirstName());
        self::assertEquals($lastName, $lecturer->getLastName());
    }
}
