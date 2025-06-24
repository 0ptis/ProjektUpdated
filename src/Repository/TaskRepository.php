<?php

/**
 * Task repository.
 */

namespace App\Repository;

use App\Dto\TaskListFiltersDto;
use App\Entity\Category;
use App\Entity\Lista;
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
            ->select('task', 'category', 'lista')
            ->leftJoin('task.category', 'category')
            ->leftJoin('task.lista', 'lista')
            ->andWhere('task.author = :author')
            ->setParameter('author', $user);

        if (null !== $filters->lista) {
            $qb->andWhere('task.lista = :lista')
                ->setParameter('lista', $filters->lista);
        }

        if (null !== $filters->category) {
            $qb->andWhere('task.category = :category')
                ->setParameter('category', $filters->category);
        }

        return $qb;
    }

    /**
     * Count tasks by category.
     *
     * @param Category $category Category
     *
     * @return int Number of tasks in category
     */
    public function countByCategory(Category $category): int
    {
        $qb = $this->createQueryBuilder('task');

        return $qb->select($qb->expr()->countDistinct('task.id'))
            ->where('task.category = :category')
            ->setParameter(':category', $category)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Count the number of tasks by the specified list.
     *
     * @param Lista $lista The list to filter tasks by
     *
     * @return int The count of tasks associated with the given list
     */
    public function countByLista(Lista $lista): int
    {
        $qb = $this->createQueryBuilder('task');

        return $qb->select($qb->expr()->countDistinct('task.id'))
            ->where('task.lista = :lista')
            ->setParameter(':lista', $lista)
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

    /**
     * Apply filters to paginated list.
     *
     * @param QueryBuilder       $queryBuilder Query builder
     * @param TaskListFiltersDto $filters      Filters
     *
     * @return QueryBuilder Query builder
     */
    private function applyFiltersToList(QueryBuilder $queryBuilder, TaskListFiltersDto $filters): QueryBuilder
    {
        if ($filters->category instanceof Category) {
            $queryBuilder->andWhere('category = :category')
                ->setParameter('category', $filters->category);
        }
        if ($filters->lista instanceof Lista) {
            $queryBuilder->andWhere('lista = :lista')
                ->setParameter('lista', $filters->lista);
        }

        return $queryBuilder;
    }
}
