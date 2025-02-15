<?php
namespace App\Controllers;
use App\Dtos\Response;

interface BaseController
{
    public function create($request): Response;

    public function get($request): Response;

    public function update($request): Response;
    public function list($request): Response;

    public function delete($request): Response;
}