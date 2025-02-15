<?php
namespace App\Entities;

/**
 * Interface implementada pelos DTOs de criação
 * @template T for Entity
 */
interface EntityProvider
{
    /**
     * @return T
     */
    public function toEntity();
}