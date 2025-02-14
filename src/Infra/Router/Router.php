<?php
namespace App\Infra\Router;

use DI\Container;

class Router
{
    private RouterNode $node;
    private static Router|null $instance = null;

    private function __construct()
    {
        $this->node = new RouterNode('/');
    }

    public static function getInstance(): Router
    {
        if (self::$instance === null) {
            self::$instance = new Router();
        }

        return self::$instance;
    }

    public function post(string $path, callable $dispatcher): void
    {
        $this->node->insert($path, 'POST', $dispatcher);
    }

    public function get(string $path, callable $dispatcher): void
    {
        $this->node->insert($path, 'GET', $dispatcher);
    }

    public function put(string $path, callable $dispatcher): void
    {
        $this->node->insert($path, 'PUT', $dispatcher);
    }

    public function patch(string $path, callable $dispatcher): void
    {
        $this->node->insert($path, 'PATCH', $dispatcher);
    }

    public function delete(string $path, callable $dispatcher): void
    {
        $this->node->insert($path, 'DELETE', $dispatcher);
    }

    public function handler(): void
    {
        $path = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        [$handler, $variables] = $this->node->match($path, $method);

        if ($handler === null) {
            RouterUtils::makeResponse(["message" => "router not found"], 404);
        }

        $response = $handler([
            "body" => RouterUtils::getBody(),
            "variables" => $variables
        ]);

        RouterUtils::makeResponse($response);
    }
}

