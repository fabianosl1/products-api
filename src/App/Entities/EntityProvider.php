<?php
namespace App\Entities;

/**
 * @template T for Entity
 */
interface EntityProvider
{
    /**
     * @return T
     */
    public function toEntity();
}