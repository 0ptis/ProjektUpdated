<?php

/**
 * Task list filters DTO.
 */

namespace App\Dto;

use App\Entity\Category;
use App\Entity\Lista;

/**
 * Class TaskListFiltersDto.
 */
class TaskListFiltersDto
{
    /**
     * Constructor.
     *
     * @param Category|null $category Category entity
     * @param Lista|null    $lista    Lista entity
     */
    public function __construct(public readonly ?Category $category, public readonly ?Lista $lista)
    {
    }
}
