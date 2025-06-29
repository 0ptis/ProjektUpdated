<?php

/**
 * Task list input filters DTO.
 */

namespace App\Dto;

/**
 * Class TaskListInputFiltersDto.
 */
class TaskListInputFiltersDto
{
    /**
     * Constructor.
     *
     * @param int|null $listaId TaskList identifier
     */
    public function __construct(public readonly ?int $listaId = null)
    {
    }
}
