<?php

/**
 * TaskList repository.
 */

namespace App\Repository;

use App\Entity\TaskList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TaskListRepository.
 *
 * @extends ServiceEntityRepository<TaskList>
 */
class TaskListRepository extends ServiceEntityRepository
{
    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskList::class);
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->createQueryBuilder('task_list');
    }

    /**
     * Save entity.
     *
     * @param TaskList $taskList TaskList entity
     */
    public function save(TaskList $taskList): void
    {
        $this->getEntityManager()->persist($taskList);
        $this->getEntityManager()->flush();
    }

    /**
     * Delete entity.
     *
     * @param TaskList $taskList TaskList entity
     */
    public function delete(TaskList $taskList): void
    {
        $this->getEntityManager()->remove($taskList);
        $this->getEntityManager()->flush();
    }
}
