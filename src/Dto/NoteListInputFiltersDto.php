<?php

/**
 * Note list input filters DTO.
 */

namespace App\Dto;

/**
 * Class NoteListInputFiltersDto.
 */
class NoteListInputFiltersDto
{
    /**
     * Constructor.
     *
     * @param int|null $categoryId Category identifier
     */
    public function __construct(public readonly ?int $categoryId = null)
    {
    }
}
