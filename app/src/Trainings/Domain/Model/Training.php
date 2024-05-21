<?php

namespace App\Trainings\Domain\Model;

use App\Trainings\Infrastructure\Repository\TrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'app_training', schema: 'simpleDb')]
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

    /**
     * @param string $name Training name.
     * @param Lecturer $lecturer Lecturer who will lead the training.
     * @param \DateTimeImmutable $dateTime Date and time of the training term.
     * @param string $price Price of the training.
     */
    public function __construct(string $name, Lecturer $lecturer, \DateTimeImmutable $dateTime, string $price)
    {
        $this->changeName($name);
        $this->lecturer = $lecturer;
        $this->trainingTerm = new ArrayCollection();
        $this->trainingTerm->add(new TrainingTerm($this, $dateTime, $price));
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function changeName(string $name): void
    {
        if (mb_strlen($name) > 512) {
            throw new \DomainException('Provided name is too long');
        }
        if (mb_strlen($name) == 0) {
            throw new \DomainException('Provided name is empty');
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

        throw new \DomainException('Invalid training term ID provided');
    }

    public function changePrice(string $trainingTermId, string $price): void
    {
        foreach ($this->trainingTerm as $trainingTerm) {
            if ($trainingTermId === $trainingTerm->getId()) {
                $trainingTerm->changePrice($price);
                return;
            }
        }

        throw new \DomainException('Invalid training term ID provided');
    }

    public function getTrainingTerms(): array
    {
        return $this->trainingTerm->toArray();
    }
}
