<?php

/**
 * TaskList service interface.
 */

namespace App\Service;

use App\Entity\TaskList;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface TaskListServiceInterface.
 */
interface TaskListServiceInterface
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
     * @param TaskList $taskList TaskList entity
     */
    public function save(TaskList $taskList): void;

    /**
     * Delete a task list entity.
     *
     * @param TaskList $taskList TaskList entity to delete
     */
    public function delete(TaskList $taskList): void;

    /**
     * Can TaskList be deleted?
     *
     * @param TaskList $taskList entity
     *
     * @return bool Result
     */
    public function canBeDeleted(TaskList $taskList): bool;
}
