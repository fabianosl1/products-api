<?php
namespace App\Exceptions;

class HttpException extends \Error {

    private int $status;

    private array $body;

    public function __construct($message, $status) {
        parent::__construct($message);
        $this->status = $status;
        $this->body  = ["message" => $message];
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return array<string, string>
     */
    public function getBody(): array
    {
        return $this->body;
    }
}
