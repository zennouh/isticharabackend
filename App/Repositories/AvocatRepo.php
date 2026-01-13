<?php

namespace App\Repository;

use App\Entity\Avocat;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class AvocatRepo extends EntityRepository
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Avocat::class));
        $this->em = $em;
    }

    // Example: Find by speciality
    public function findBySpecialite(string $specialite): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.specialite = :specialite')
            ->setParameter('specialite', $specialite)
            ->getQuery()
            ->getResult();
    }

    // Example: Find online lawyers
    public function findConsultEnLigne(): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.consultEnLigne = :yes')
            ->setParameter('yes', 'yes')
            ->getQuery()
            ->getResult();
    }

    // Save an avocat
    public function save(Avocat $avocat, bool $flush = true): void
    {
        $this->em->persist($avocat);
        if ($flush) {
            $this->em->flush();
        }
    }

    // Delete an avocat
    public function remove(Avocat $avocat, bool $flush = true): void
    {
        $this->em->remove($avocat);
        if ($flush) {
            $this->em->flush();
        }
    }
}
