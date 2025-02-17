<?php
namespace Router;

class RouterUtils
{

    public static function makeResponse(Response $response): void
    {
        http_response_code($response->getStatus());

        $body = $response->getBody();

        if (!is_string($body)) {
            header('Content-Type: application/json');
            $body = json_encode($response->getBody());
        } else {
            header('Content-Type: text/plain');
        }

        echo $body;
    }
    /**
     * @return array<callable():Response,Request>
     */
    public static function getRequest(Router $router): array
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        $result = explode('?', $uri);

        $path = $result[0];

        $query = $result[1] ?? null;

        [$handler, $variables] = $router->match($path, $method);

        $request = [
            "body" => self::getBody() ?? [],
            "variables" => $variables,
            "params" => self::getParams($query)
        ];

        $request = new Request(self::getBody() ?? [], $variables, self::getParams($query));

        return [$handler, $request];
    }


    private static function getBody(): mixed
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    private static function getParams(string|null $query): array
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
