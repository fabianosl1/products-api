<?php
namespace App\Controllers;
use Router\Request;
use Router\Response;

interface BaseController
{
   public function create(Request $request): Response;

    public function get(Request $request): Response;

    public function update(Request $request): Response;

    public function list(Request $request): Response;

    public function delete(Request $request): Response;
}
