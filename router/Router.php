<?php
class Router {
    private Node $node;

    public function __construct() {
        $this->node = new Node('/');
    }

    public function post(string $path, callable $dispatcher): void {
        $this->node->insert($path, 'POST', $dispatcher);
    }

    public function handler(string $path, string $method): void {
        $handler = $this->node->match($path, $method);

        if ($handler === null) {
            RouterUtils::makeResponse(["message" => "router not found"], 404);
        }

        $handler();
    }
}

class Node {
    private string $pathPart;

    private array $nodes;

    private array $dispatcher;

    public function __construct($path) {
        $this->pathPart = $path;
        $this->nodes = array();
    }

    private function addDispatcher(string $method, callable $dispatcher): void {
        $this->dispatcher[$method] = $dispatcher;
    }

    public function insert(string $path, string $method, callable $dispatcher): void {
        if ($path == '/') {
            $this->addDispatcher($method, $dispatcher);
        }

        $current = $this;

        foreach (explode('/', $path) as $pathPart) {
            $next = $current->nodes[$pathPart];
            if ($next !== null) {
                $current = $next;
            } else {
                $current->nodes[$pathPart] = new Node($pathPart);
                $current = $current->nodes[$pathPart];
                $current->addDispatcher($method, $dispatcher);
            }
        }
    }

    public function match(string $path, string $method): ?callable {
        $current = $this;

        if ($path == '/' || empty($path)) {

        }
        foreach (explode('/', $path) as $pathPart) {
            $next = $current->nodes[$pathPart];

            if ($next !== null) {
                $current = $next;
                continue;
            }

            if ($current->pathPart !== $pathPart) {
                return null;
            }
        }

        return $current->dispatcher[$method];
    }
}