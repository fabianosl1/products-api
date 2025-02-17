<?php
namespace App\Exceptions;

class NotFoundException extends HttpException
{
    public function __construct($message)
    {
        parent::__construct($message, 404);
    }
}