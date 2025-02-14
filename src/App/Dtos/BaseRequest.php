<?php

namespace App\Dtos;

use App\Entities\EntityProvider;

abstract class BaseRequest implements EntityProvider
{
    abstract public function __construct(array $body);
}