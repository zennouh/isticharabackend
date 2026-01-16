<?php

namespace App\Repositories;

use App\Core\Services\ObjectMapper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

abstract class BaseRepository
{
    protected EntityManagerInterface $em;
    protected string $entityClass;
    protected string $alias = 'e';



    protected function qb(): QueryBuilder
    {
        return $this->em->createQueryBuilder()
            ->select($this->alias)
            ->from($this->entityClass, $this->alias)
        ;
    }


    public function findAll(): array
    {
        return $this->qb()
            ->getQuery()
            ->getResult(); // ENTITY objects
    }
    public function find(int $id): ?object
    {
        return $this->qb()
            ->where("{$this->alias}.id = :id")
            ->setParameter('id', $id)

            ->getQuery()
            ->getOneOrNullResult();
    }



    public function findBy(array $criteria, ?int $limit = null, ?int $offset = null): array
    {
        $qb = $this->qb();

        foreach ($criteria as $field => $value) {
            $qb->andWhere("{$this->alias}.$field = :$field")
                ->setParameter($field, $value);
        }

        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }

        if ($offset !== null) {
            $qb->setFirstResult($offset);
        }

        return $qb->getQuery()->getResult(); // ENTITY objects
    }


    public function findOneBy(array $criteria): ?object
    {
        return $this->findBy($criteria, 1)[0] ?? null;
    }

    public function save(object $entity, bool $flush = true): void
    {
        $this->em->persist($entity);

        if ($flush) {
            $this->em->flush();
        }
    }
    public function update(object $entity, bool $flush = true): void
    {
        
        $this->em->persist($entity);
        if ($flush) {
            $this->em->flush();
        }
    }
    public function delete(string $entity, int $id): void
    {
        $avocat = $this->em->find($entity, $id);

        if ($avocat) {
            $this->em->remove($avocat);
            $this->em->flush();
        }
    }
}
