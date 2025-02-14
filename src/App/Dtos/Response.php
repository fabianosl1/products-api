<?php

namespace App\Dtos;

class Response
{

    private BaseResponse $body;

    private int $status;

    public function __construct(BaseResponse $body, int $status = 200)
    {
        $this->body = $body;
        $this->status = $status;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getStatus()
    {
        return $this->status;
    }
}