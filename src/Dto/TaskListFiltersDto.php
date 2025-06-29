<?php

/**
 * Task list filters DTO.
 */

namespace App\Dto;

use App\Entity\TaskList;

/**
 * Class TaskListFiltersDto.
 */
class TaskListFiltersDto
{
    /**
     * Constructor.
     *
     * @param TaskList|null $taskList TaskList entity
     */
    public function __construct(public readonly ?TaskList $taskList)
    {
    }
}
