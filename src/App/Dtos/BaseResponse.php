<?php
namespace App\Dtos;

/**
 * @template T
 */
abstract class BaseResponse
{
    /**
     * @param $entity T
     */
    abstract public function __construct($entity);
}