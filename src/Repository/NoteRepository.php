<?php

/**
 * Note repository.
 */

namespace App\Repository;

use App\Dto\NoteListFiltersDto;
use App\Entity\Category;
use App\Entity\Note;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class NoteRepository.
 *
 * @extends ServiceEntityRepository<Note>
 */
class NoteRepository extends ServiceEntityRepository
{
    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    /**
     * Query all records.
     *
     * @param User               $user    User
     * @param NoteListFiltersDto $filters Filters
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(User $user, NoteListFiltersDto $filters): QueryBuilder
    {
        $qb = $this->createQueryBuilder('note')
            ->select('note', 'category')
            ->leftJoin('note.category', 'category')
            ->andWhere('note.author = :author')
            ->setParameter('author', $user);

        if (null !== $filters->category) {
            $qb->andWhere('note.category = :category')
                ->setParameter('category', $filters->category);
        }

        return $qb;
    }

    /**
     * Count notes by category.
     *
     * @param Category $category Category
     *
     * @return int Number of notes in category
     */
    public function countByCategory(Category $category): int
    {
        return $this->createQueryBuilder('note')
            ->select('COUNT(note.id)')
            ->where('note.category = :category')
            ->setParameter(':category', $category)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Save entity.
     *
     * @param Note $note Note entity
     */
    public function save(Note $note): void
    {
        $this->getEntityManager()->persist($note);
        $this->getEntityManager()->flush();
    }

    /**
     * Delete entity.
     *
     * @param Note $note Note entity
     */
    public function delete(Note $note): void
    {
        $this->getEntityManager()->remove($note);
        $this->getEntityManager()->flush();
    }
}
