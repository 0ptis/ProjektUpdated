<?php

/**
 * Lista repository.
 */

namespace App\Repository;

use App\Entity\Lista;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ListaRepository.
 *
 * @extends ServiceEntityRepository<Lista>
 */
class ListaRepository extends ServiceEntityRepository
{
    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lista::class);
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->createQueryBuilder('lista');
    }

    /**
     * Save entity.
     *
     * @param Lista $lista Lista entity
     */
    public function save(Lista $lista): void
    {
        $this->getEntityManager()->persist($lista);
        $this->getEntityManager()->flush();
    }

    /**
     * Delete entity.
     *
     * @param Lista $lista Lista entity
     */
    public function delete(Lista $lista): void
    {
        $this->getEntityManager()->remove($lista);
        $this->getEntityManager()->flush();
    }
}
