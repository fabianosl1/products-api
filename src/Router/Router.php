<?php
namespace Router;

use App\Exceptions\HttpException;
use App\Exceptions\NotFoundException;

use App\Logger;

use Throwable;

class Router
{
    private Logger $logger;

    private RouterNode $node;

    private static Router|null $instance = null;

    private function __construct()
    {
        $this->node = new RouterNode("/");
        $this->logger = new Logger(Router::class);
    }

    public static function getInstance(): Router
    {
        if (self::$instance === null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    /**
     * @@param callable():void $init
     */
    public function run(callable $init): void
    {
        try {
            $init();
        } catch (Throwable $error) {
            $this->logger->critical($error->getMessage());
            $response = new Response("Server not initialized", 500);
            RouterUtils::makeResponse($response);
            return;
        }

        $response = $this->ensureSuccess([$this, 'dispatch']);
        RouterUtils::makeResponse($response);
    }

    private function dispatch(): Response
    {
        [$handler, $request] = RouterUtils::getRequest($this);

        if ($handler === null) {
            throw new NotFoundException("No route found");
        }

        return $handler($request);
    }

    /**
     * @param callable(): Response $callback
     */
    private function ensureSuccess(callable $callback): Response {
        try {
            return $response = $callback($this);
        } catch (HttpException $exception) {
            return new Response($exception->getBody(), $exception->getStatus());
        } catch (Throwable $exception) {
            return new Response($exception->getMessage(), 500);
        }
    }

    /**
     * @param callable(): Response $dispatcher
     */
    public function post(string $path, callable $dispatcher): void
    {
        $this->node->insert($path, 'POST', $dispatcher);
    }

    /**
     * @param callable(): Response $dispatcher
     */
    public function get(string $path, callable $dispatcher): void
    {
        $this->node->insert($path, 'GET', $dispatcher);
    }

    /**
     * @param callable(): Response $dispatcher
     */
    public function put(string $path, callable $dispatcher): void
    {
        $this->node->insert($path, 'PUT', $dispatcher);
    }

    /**
     * @param callable(): Response $dispatcher
     */
    public function patch(string $path, callable $dispatcher): void
    {
        $this->node->insert($path, 'PATCH', $dispatcher);
    }

    /**
     * @param callable(): Response $dispatcher
     */
    public function delete(string $path, callable $dispatcher): void
    {
        $this->node->insert($path, 'DELETE', $dispatcher);
    }

    /**
     * @return array<callable(): Response,mixed>
     */
    public function match(string $path, string $method): array
    {
        return $this->node->match($path, $method);
    }
}
