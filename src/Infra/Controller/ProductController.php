<?php
namespace App\Infra\Controller;

class ProductController
{
    public function get($request): array
    {

        return ["body" => $request['body'], "variables" => $request['variables']];
    }
}