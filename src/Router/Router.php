<?php
namespace Router;

use App\Exceptions\HttpException;
use App\Exceptions\NotFoundException;
use Throwable;

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

    public function run(): void
    {
        [$body, $status] =$this->ensureSuccess([$this, 'dispatcher']);
        RouterUtils::makeResponse($body, $status);
    }

    /**
     * @throws NotFoundException
     */
    private function dispatcher()
    {
        [$handler, $request] = RouterUtils::getRequest($this);

        if ($handler === null) {
            throw new NotFoundException("No route found");
        }

        return $handler($request);
    }

    private function ensureSuccess(callable $callback): array {
        try {
            $response = $callback($this);
            return [$response->getBody(), $response->getStatus()];
        } catch (HttpException $exception) {
            return [["message" => $exception->getMessage()], $exception->getStatus()];
        } catch (Throwable $exception) {
            return [["message" => $exception->getMessage(),
                "stack" => $exception->getTrace()] , 400];
        }
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

    public function match(string $path, string $method): array
    {
        return $this->node->match($path, $method);
    }

}

