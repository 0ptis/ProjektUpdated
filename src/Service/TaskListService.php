<?php

/**
 * TaskList service.
 */

namespace App\Service;

use App\Entity\TaskList;
use App\Repository\TaskListRepository;
use App\Repository\TaskRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class TaskListService.
 */
class TaskListService implements TaskListServiceInterface
{
    private const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor for TaskList.
     *
     * @param TaskListRepository $taskListRepository TaskList Repository
     * @param PaginatorInterface $paginator          paginator
     * @param TaskRepository     $taskRepository     Task Repository
     */
    public function __construct(private readonly TaskListRepository $taskListRepository, private readonly PaginatorInterface $paginator, private readonly TaskRepository $taskRepository)
    {
    }

    /**
     * Retrieves a paginated list of task lists with specified sorting options.
     *
     * @param int $page the current page number for pagination
     *
     * @return PaginationInterface the paginated result containing task lists
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->taskListRepository->queryAll(),
            $page,
            self::PAGINATOR_ITEMS_PER_PAGE,
            [
                'sortFieldAllowList' => ['task_list.id', 'task_list.createdAt', 'task_list.updatedAt', 'task_list.title'],
                'defaultSortFieldName' => 'task_list.updatedAt',
                'defaultSortDirection' => 'desc',
            ]
        );
    }

    /**
     * Saves the given TaskList entity to the repository.
     *
     * Ensures that the "updatedAt" timestamp is set during saving.
     * If the entity is new and does not have an ID, also sets the "createdAt" timestamp.
     *
     * @param TaskList $taskList the task list entity to save
     */
    public function save(TaskList $taskList): void
    {
        $taskList->setUpdatedAt(new \DateTimeImmutable());
        if (null === $taskList->getId()) {
            $taskList->setCreatedAt(new \DateTimeImmutable());
        }
        $this->taskListRepository->save($taskList);
    }

    /**
     * Deletes the given task list from the repository.
     *
     * @param TaskList $taskList the task list entity to be deleted
     */
    public function delete(TaskList $taskList): void
    {
        $this->taskListRepository->delete($taskList);
    }

    /**
     * Finds and returns a single task list by its unique identifier.
     *
     * @param int $id the unique identifier of the task list
     *
     * @return TaskList|null the task list if found, or null if no task list matches the given identifier
     */
    public function findOneById(int $id): ?TaskList
    {
        return $this->taskListRepository->findOneById($id);
    }

    /**
     * Determines whether a task list can be safely deleted.
     *
     * A task list can be deleted if it does not contain any associated tasks.
     * If an exception occurs during the process, deletion is considered not possible.
     *
     * @param TaskList $taskList the task list to be checked
     *
     * @return bool true if the task list can be deleted, false otherwise
     */
    public function canBeDeleted(TaskList $taskList): bool
    {
        try {
            $result = $this->taskRepository->countByTaskList($taskList);

            return !($result > 0);
        } catch (\Exception) {
            return false;
        }
    }
}
