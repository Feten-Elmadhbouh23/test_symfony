<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    /**
     * Trouve les clients ayant une adresse dans une zone spécifique.
     *
     * @param string $zone
     * @return Client[] Retourne un tableau de clients
     */
    public function findByAdresse($zone): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.adresse LIKE :zone')
            ->setParameter('zone', '%'.$zone.'%')
            ->getQuery()
            ->getResult();
    }
}
