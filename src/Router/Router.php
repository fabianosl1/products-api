<?php
namespace Router;

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
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        [$path, $query] = explode('?', $uri);

        [$handler, $variables] = $this->node->match($path, $method);

        if ($handler === null) {
            RouterUtils::makeResponse(["message" => "router not found"], 404);
        }

        $response = $handler([
            "body" => RouterUtils::getBody(),
            "variables" => $variables,
            "params" => $this->getParams($query)
        ]);

        RouterUtils::makeResponse($response->getBody(), $response->getStatus());
    }

    private function getParams(string|null $query): array
    {
        $params = [];

        if ($query === null) {
            return $params;
        }

        foreach (explode("&", $query) as $param) {
            $param = trim($param);

            if (empty($param)) {
                continue;
            }

            [$key, $value] = explode("=", $param);

            $params[$key] = $value;
        }
        return $params;
    }
}

