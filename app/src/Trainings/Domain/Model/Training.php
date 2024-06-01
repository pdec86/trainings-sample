<?php

namespace App\Trainings\Domain\Model;

use App\Trainings\Domain\Model\Exceptions\NameEmptyException;
use App\Trainings\Domain\Model\Exceptions\NameTooLongException;
use App\Trainings\Infrastructure\Repository\TrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'app_training')]
#[ORM\Entity(repositoryClass: TrainingRepository::class)]
class Training
{
    #[ORM\Column(name: 'id', type: 'bigint')]
    #[ORM\GeneratedValue()]
    #[ORM\Id]
    private string $id;

    #[ORM\Column(name: 'name', type: 'string', length: 512, unique: true, nullable: false)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: Lecturer::class)]
    #[ORM\JoinColumn(name: 'lecturerId', referencedColumnName: 'id', nullable: false)]
    private Lecturer $lecturer;

    /**
     * @var Collection<TrainingTerm>|TrainingTerm[]
     */
    #[ORM\OneToMany(targetEntity: TrainingTerm::class, mappedBy: 'training', cascade: ['refresh', 'persist', 'remove'])]
    private Collection $trainingTerm;

    protected function __construct()
    {
        $this->trainingTerm = new ArrayCollection();
    }

    /**
     * @param string $name Training name.
     * @param Lecturer $lecturer Lecturer who will lead the training.
     * @param \DateTimeImmutable $dateTime Date and time of the training term.
     * @param string $price Price of the training.
     */
    public static function createWithSingleTerm(
        string $name,
        Lecturer $lecturer,
        \DateTimeImmutable $dateTime,
        string $price
    ): self {
        $training = new self();
        $training->changeName($name);
        $training->lecturer = $lecturer;
        $training->trainingTerm->add(new TrainingTerm($training, $dateTime, $price));

        return $training;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function changeName(string $name): void
    {
        if (mb_strlen($name) > 512) {
            throw new NameTooLongException('Provided name is too long');
        }
        if (mb_strlen($name) == 0) {
            throw new NameEmptyException('Provided name is empty');
        }

        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function changeLecturer(Lecturer $lecturer): void
    {
        $this->lecturer = $lecturer;
    }

    public function getLecturer(): Lecturer
    {
        return $this->lecturer;
    }

    public function changeDateAndTime(string $trainingTermId, \DateTimeImmutable $dateTime): void
    {
        foreach ($this->trainingTerm as $trainingTerm) {
            if ($trainingTermId === $trainingTerm->getId()) {
                $trainingTerm->changeDateAndTime($dateTime);
                return;
            }
        }

        throw new \LogicException('Invalid training term ID provided');
    }

    public function changePrice(string $trainingTermId, string $price): void
    {
        foreach ($this->trainingTerm as $trainingTerm) {
            if ($trainingTermId === $trainingTerm->getId()) {
                $trainingTerm->changePrice($price);
                return;
            }
        }

        throw new \LogicException('Invalid training term ID provided');
    }

    public function getTrainingTerms(): array
    {
        return $this->trainingTerm->toArray();
    }
}
