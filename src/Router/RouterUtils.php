<?php
namespace Router;

class RouterUtils
{

    public static function makeResponse(Response $response): void
    {
        header('X-powered-by: Micro router');
        http_response_code($response->getStatus());

        if ($response->getStatus() < 500) {
            header('Content-Type: application/json');
            echo json_encode($response->getBody());
        } else {
            echo $response->getBody();
        }
    }
    /**
     * @return array<callable():Response,Request>
     */
    public static function getRequest(Router $router): array {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        [$path, $query] = explode('?', $uri);

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
