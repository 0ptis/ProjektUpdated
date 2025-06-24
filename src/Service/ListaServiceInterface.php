<?php

/**
 * Lista service interface.
 */

namespace App\Service;

use App\Entity\Lista;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface ListaServiceInterface.
 */
interface ListaServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Lista $lista Lista entity
     */
    public function save(Lista $lista): void;

    /**
     * Delete a lista entity.
     *
     * @param Lista $lista Lista entity to delete
     */
    public function delete(Lista $lista): void;

    /**
     * Can Category be deleted?
     *
     * @param Lista $lista Category entity
     *
     * @return bool Result
     */
    public function canBeDeleted(Lista $lista): bool;
}
