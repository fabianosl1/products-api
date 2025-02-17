<?php
namespace Router;

/*
 * Implementação baseada no framework Hono.js (primeiros commits)
 *
 * As rotas são construidas em uma estrutura de arvore, cada nó possui:
 *  - parte do path
 *  - map <verbo http>:<handler>
 *  - sub nodes
 *
 * dado um path a função match encontra o RouterNode
 * adequado e retorna o handler de acordo com o verbo http
 */
class RouterNode
{
    private string $pathPart;

    private array $nodes;

    /**
     * @var callable():Response[]
     */
    private array $dispatcher;

    private bool $containsDynamic;

    public function __construct(string $path)
    {
        $this->pathPart = $path;
        $this->nodes = [];
        $this->dispatcher = [];
        $this->containsDynamic = false;
    }
    /**
     * @param callable(): Response $dispatcher
     */
    private function addDispatcher(string $method, callable $dispatcher): void
    {
        $this->dispatcher[$method] = $dispatcher;
    }
    /**
     * @param callable(): Response $dispatcher
     */
    public function insert(string $path, string $method, callable $dispatcher): void
    {
        if ($path == '/') {
            $this->addDispatcher($method, $dispatcher);
        }

        $current = $this;

        foreach ($this->explodePath($path) as $pathPart) {
            $next = $current->nodes[$pathPart] ?? null;

            if (str_contains($pathPart, ':')) {
                $current->containsDynamic = true;
            }

            if ($next !== null) {
                $current = $next;
            } else {
                $current->nodes[$pathPart] = new RouterNode($pathPart);
                $current = $current->nodes[$pathPart];
            }
        }

        $current->addDispatcher($method, $dispatcher);
    }
    /**
     * @return array<callable():Response,mixed>
     */
    public function match(string $path, string $method): array
    {
        $variables = [];
        $current = $this;
        $paths = $this->explodePath($path);
        $total = count($paths);
        $index = 0;

        foreach ($paths as $pathPart) {
            $next = $current->nodes[$pathPart] ?? null;

            if ($current->containsDynamic) {
                $child = reset($current->nodes);
                $variables[substr($child->pathPart, 1)] = $pathPart;

                if ($index < $total) {
                    $next = $child;
                }
            }

            $current = $next;
        }

        return [$current->dispatcher[$method], $variables];
    }

    private function explodePath(string $path): array
    {
        return array_filter(explode('/', $path), function ($item) {
            return $item !== '';
        });
    }
}
