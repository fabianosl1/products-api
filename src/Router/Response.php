<?php
namespace Router;

class Response
{
    private mixed $body;

    private int $status;

    public function __construct(mixed $body, int $status = 200)
    {
        $this->body = $body;
        $this->status = $status;
    }

    public function getBody(): mixed
    {
        return $this->body;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
