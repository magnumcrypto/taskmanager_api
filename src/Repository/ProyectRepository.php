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

    public function save(Proyect $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getProyectsJSON(): array
    {
        $proyects = $this->findAll();
        $proyectsJSON = [];
        foreach ($proyects as $proyect) {
            $proyectsJSON[] =
                [
                    'id' => $proyect->getId(),
                    'name' => $proyect->getProyectName()
                ];
        }
        return $proyectsJSON;
    }

    public function createProyect(object $proyectData): bool
    {
        if (!isset($proyectData)) {
            return false;
        }

        $newProyect = new Proyect();
        $newProyect->setProyectName($proyectData->proyect_name);
        $this->save($newProyect, true);

        $proyect = $this->findOneBy([
            'id' => $newProyect->getId(),
            'proyectName' => $newProyect->getProyectName()
        ]);
        if (!isset($proyect)) {
            return false;
        }
        return true;
    }
}
