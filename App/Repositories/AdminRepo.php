<?php

namespace App\Repository;

use App\Entity\Admin;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class AdminRepo extends EntityRepository
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Admin::class));
        $this->em = $em;
    }

    // Example: Find by speciality
    public function findBySpecialite(string $specialite): array
    {
        // return $this->createQueryBuilder('a')
        //     ->where('a.specialite = :specialite')
        //     ->setParameter('specialite', $specialite)
        //     ->getQuery()
        //     ->getResult();
        return [];
    }

    // Example: Find online lawyers
    public function findConsultEnLigne(): array
    {
        // return $this->createQueryBuilder('a')
        //     ->where('a.consultEnLigne = :yes')
        //     ->setParameter('yes', 'yes')
        //     ->getQuery()
        //     ->getResult();
        return [];
    }

    // Save an Admin
    public function save(Admin $admin, bool $flush = true): void
    {
        $this->em->persist($admin);
        if ($flush) {
            $this->em->flush();
        }
    }

    // Delete an Admin
    public function remove(Admin $admin, bool $flush = true): void
    {
        $this->em->remove($admin);
        if ($flush) {
            $this->em->flush();
        }
    }
}
