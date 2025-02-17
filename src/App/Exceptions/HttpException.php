<?php
namespace App\Exceptions;

class HttpException extends \Error {

    private int $status;

    public function __construct($message, $status) {
        parent::__construct($message);
        $this->status = $status;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

}