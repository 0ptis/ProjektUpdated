<?php

/**
 * Note list filters DTO.
 */

namespace App\Dto;

use App\Entity\Category;

/**
 * Class NoteListFiltersDto.
 */
class NoteListFiltersDto
{
    /**
     * Constructor.
     *
     * @param Category|null $category Category entity
     */
    public function __construct(public readonly ?Category $category)
    {
    }
}
