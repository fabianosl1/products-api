<?php

namespace App\Dtos;

abstract class BaseRequest
{
    abstract public function __construct(mixed $body);
}
