<?php

/**
 * Note service.
 */

namespace App\Service;

use App\Dto\NoteListFiltersDto;
use App\Dto\NoteListInputFiltersDto;
use App\Entity\Note;
use App\Entity\User;
use App\Repository\NoteRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class NoteService.
 */
class NoteService implements NoteServiceInterface
{
    private const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryService Category service
     * @param PaginatorInterface       $paginator       Paginator
     * @param NoteRepository           $noteRepository  Note repository
     */
    public function __construct(private readonly CategoryServiceInterface $categoryService, private readonly PaginatorInterface $paginator, private readonly NoteRepository $noteRepository)
    {
    }

    /**
     * Get paginated list.
     *
     * @param int                     $page    Page number
     * @param User                    $author  Notes author
     * @param NoteListInputFiltersDto $filters Filters
     *
     * @return PaginationInterface Paginated list
     */
    public function getPaginatedList(int $page, User $author, NoteListInputFiltersDto $filters): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->noteRepository->queryAll($author, $filters),
            $page,
            self::PAGINATOR_ITEMS_PER_PAGE,
            [
                'sortFieldAllowList' => ['note.id', 'note.createdAt', 'note.updatedAt', 'note.title', 'category.title'],
                'defaultSortFieldName' => 'note.createdAt',
                'defaultSortDirection' => 'desc',
            ]
        );
    }

    /**
     * Save entity.
     *
     * @param Note $note Note entity
     */
    public function save(Note $note): void
    {
        $this->noteRepository->save($note);
    }

    /**
     * Delete entity.
     *
     * @param Note $note Note entity
     */
    public function delete(Note $note): void
    {
        $this->noteRepository->delete($note);
    }

    /**
     * Prepare filters.
     *
     * @param NoteListInputFiltersDto $filters Raw filters
     *
     * @return NoteListFiltersDto Prepared filters
     */
    private function prepareFilters(NoteListInputFiltersDto $filters): NoteListFiltersDto
    {
        return new NoteListFiltersDto(
            null !== $filters->categoryId ? $this->categoryService->findOneById($filters->categoryId) : null
        );
    }
}
