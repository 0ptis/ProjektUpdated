<?php

/**
 * Lista service.
 */

namespace App\Service;

use App\Entity\Lista;
use App\Repository\ListaRepository;
use App\Repository\TaskRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class ListaService.
 */
class ListaService implements ListaServiceInterface
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    private const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param ListaRepository    $listaRepository Lista repository
     * @param PaginatorInterface $paginator       Paginator
     * @param TaskRepository     $taskRepository  Task repository
     */
    public function __construct(private readonly ListaRepository $listaRepository, private readonly PaginatorInterface $paginator, private readonly TaskRepository $taskRepository)
    {
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->listaRepository->queryAll(),
            $page,
            self::PAGINATOR_ITEMS_PER_PAGE,
            [
                'sortFieldAllowList' => ['lista.id', 'lista.createdAt', 'lista.updatedAt', 'lista.title'],
                'defaultSortFieldName' => 'lista.updatedAt',
                'defaultSortDirection' => 'desc',
            ]
        );
    }

    /**
     * Save entity.
     *
     * @param Lista $lista Lista entity
     */
    public function save(Lista $lista): void
    {
        $lista->setUpdatedAt(new \DateTimeImmutable());
        if (null === $lista->getId()) {
            $lista->setCreatedAt(new \DateTimeImmutable());
        }
        $this->listaRepository->save($lista);
    }

    /**
     * Delete a Lista entity.
     *
     * @param Lista $lista The Lista entity to be deleted
     */
    public function delete(Lista $lista): void
    {
        $this->listaRepository->delete($lista);
    }

    /**
     * Find by id.
     *
     * @param int $id Lista id
     *
     * @return Lista|null Lista entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Lista
    {
        return $this->listaRepository->findOneById($id);
    }

    /**
     * Can Category be deleted?
     *
     * @param Lista $lista entity
     *
     * @return bool Result
     */
    public function canBeDeleted(Lista $lista): bool
    {
        try {
            $result = $this->taskRepository->countByLista($lista);

            return !($result > 0);
        } catch (NoResultException|NonUniqueResultException) {
            return false;
        }
    }
}
