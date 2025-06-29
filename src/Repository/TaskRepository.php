<?php

/**
 * Task repository.
 */

namespace App\Repository;

use App\Dto\TaskListFiltersDto;
use App\Entity\TaskList;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TaskRepository.
 *
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * Query all records.
     *
     * @param User               $user    user
     * @param TaskListFiltersDto $filters filters
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(User $user, TaskListFiltersDto $filters): QueryBuilder
    {
        $qb = $this->createQueryBuilder('task')
            ->select('task', 'taskList')
            ->leftJoin('task.taskList', 'taskList')
            ->andWhere('task.author = :author')
            ->setParameter('author', $user);

        if (null !== $filters->taskList) {
            $qb->andWhere('task.taskList = :taskList')
                ->setParameter('taskList', $filters->taskList);
        }

        return $qb;
    }

    /**
     * Count the number of tasks by the specified list.
     *
     * @param TaskList $taskList The list to filter tasks by
     *
     * @return int The count of tasks associated with the given list
     */
    public function countByTaskList(TaskList $taskList): int
    {
        $qb = $this->createQueryBuilder('task');

        return $qb->select($qb->expr()->countDistinct('task.id'))
            ->where('task.taskList = :taskList')
            ->setParameter(':taskList', $taskList)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Save entity.
     *
     * @param Task $task Task entity
     */
    public function save(Task $task): void
    {
        $this->getEntityManager()->persist($task);
        $this->getEntityManager()->flush();
    }

    /**
     * Delete entity.
     *
     * @param Task $task Task entity
     */
    public function delete(Task $task): void
    {
        $this->getEntityManager()->remove($task);
        $this->getEntityManager()->flush();
    }
}
