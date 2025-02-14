<?php

class RouterNode
{
    private string $pathPart;

    private array $nodes;

    private array $dispatcher;

    public function __construct($path)
    {
        $this->pathPart = $path;
        $this->nodes = [];
    }

    private function addDispatcher(string $method, callable $dispatcher): void
    {
        $this->dispatcher[$method] = $dispatcher;
    }

    public function insert(string $path, string $method, callable $dispatcher): void
    {
        if ($path == '/') {
            $this->addDispatcher($method, $dispatcher);
        }

        $current = $this;

        foreach (explode('/', $path) as $pathPart) {
            $next = $current->nodes[$pathPart];
            if ($next !== null) {
                $current = $next;
            } else {
                $current->nodes[$pathPart] = new RouterNode($pathPart);
                $current = $current->nodes[$pathPart];
                $current->addDispatcher($method, $dispatcher);
            }
        }
    }

    public function match(string $path, string $method): ?callable
    {
        $current = $this;

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