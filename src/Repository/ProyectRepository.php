<?php

namespace App\Repository;

use App\Entity\Proyect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Proyect>
 */
class ProyectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proyect::class);
    }

    public function getTasksJSON()
    {
    }
}
