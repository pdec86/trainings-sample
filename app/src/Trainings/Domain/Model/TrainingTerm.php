<?php

namespace App\Trainings\Domain\Model;

use App\Trainings\Domain\Model\Exceptions\DateTimeInPastException;
use App\Trainings\Domain\Model\Exceptions\InvalidPriceException;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Clock\ClockAwareTrait;

#[ORM\Table(name: 'app_training_term')]
#[ORM\Entity()]
class TrainingTerm
{
    use ClockAwareTrait;

    #[ORM\Column(name: 'id', type: 'bigint')]
    #[ORM\GeneratedValue()]
    #[ORM\Id]
    private ?string $id = null;

    #[ORM\Column(name: 'dateAndTime', type: "datetime_immutable")]
    private \DateTimeImmutable $dateTime;

    #[ORM\Column(name: 'price', type: "decimal", precision: 12, scale: 2)]
    private string $price;

    #[ORM\ManyToOne(targetEntity: Training::class, inversedBy: 'trainingTerm')]
    #[ORM\JoinColumn(name: 'training_id', referencedColumnName: 'id', nullable: false)]
    private Training $training;

    /**
     * @param Training $training
     * @param \DateTimeImmutable $dateTime
     * @param string $price
     */
    public function __construct(Training $training, \DateTimeImmutable $dateTime, string $price)
    {
        $this->training = $training;
        $this->changeDateAndTime($dateTime);
        $this->changePrice($price);
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getDateTime(): \DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function changeDateAndTime(\DateTimeImmutable $dateTime): void
    {
        if ($dateTime < $this->now()) {
            throw new DateTimeInPastException('Date and time in past. Must be in future');
        }

        $this->dateTime = $dateTime;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function changePrice(string $price): void
    {
        if (!preg_match('/^-?\d+(\.\d+)?$/', $price)) {
            throw new InvalidPriceException('Invalid price provided');
        }

        if (\bccomp($price, '0.00', 2) < 0) {
            throw new InvalidPriceException('Price must be greater or equal 0');
        }

        $this->price = $price;
    }
}
