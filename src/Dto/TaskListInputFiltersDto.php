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
     * @param int|null $categoryId Category identifier
     * @param int|null $listaId    Lista identifier
     */
    public function __construct(public readonly ?int $categoryId = null, public readonly ?int $listaId = null)
    {
    }
}
