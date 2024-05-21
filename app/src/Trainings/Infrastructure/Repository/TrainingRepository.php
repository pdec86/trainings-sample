<?php

namespace App\Trainings\Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;

class TrainingRepository extends EntityRepository
{
    public function fetchList(
        ?string $trainingName = null,
        ?string $trainingLecturer = null,
        ?string $trainingTermDate = null
    ): array {
        $queryBuilder = $this->createQueryBuilder('training');
        $expr = $queryBuilder->expr();

        $queryBuilder->select('training, terms')
            ->innerJoin('training.trainingTerm', 'terms')
            ->innerJoin('training.lecturer', 'lecturer');

        if (null != $trainingName) {
            $queryBuilder->andWhere($expr->like('training.name', ':trainingName'));
            $queryBuilder->setParameter('trainingName', $trainingName);
        }

        if (null != $trainingLecturer) {
            $queryBuilder->andWhere($expr->orX(
                $expr->like('lecturer.firstName', ':lecturerName'),
                $expr->like('lecturer.lastName', ':lecturerName')
            ));
            $queryBuilder->setParameter('lecturerName', $trainingLecturer);
        }

        if (null != $trainingTermDate) {
            $queryBuilder->andWhere($expr->like('terms.dateTime', ':trainingDateTime'));
            $queryBuilder->setParameter('trainingDateTime', (new \DateTimeImmutable($trainingTermDate))->format('Y-m-d') . '%');
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function fetchCountForDate(string $date): int
    {
        $queryBuilder = $this->createQueryBuilder('training');
        $expr = $queryBuilder->expr();

        $queryBuilder->select($expr->count('training.id'))
            ->innerJoin('training.trainingTerm', 'terms');

        if (null != $date) {
            $queryBuilder->andWhere($expr->like('terms.dateTime', ':trainingDateTime'));
            $queryBuilder->setParameter('trainingDateTime', (new \DateTimeImmutable($date))->format('Y-m-d') . '%');
        }

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }
}