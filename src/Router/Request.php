<?php
namespace Router;

class Request
{
    private mixed $body;

    private array $variables;

    private array $queries;

    /**
     * @param array<string,mixed> $variables
     * @param array<string,mixed> $queries
     */
    public function __construct(mixed $body, array $variables, array $queries)
    {
        $this->body = $body;
        $this->variables = $variables;
        $this->queries = $queries;
    }

    public function getBody(): mixed
    {
        return $this->body;
    }

    public function getVariable(string $key): mixed
    {
        return $this->variables["$key"];
    }

    public function getQuery(string $query): mixed
    {
        return $this->queries[$query];
    }
}
