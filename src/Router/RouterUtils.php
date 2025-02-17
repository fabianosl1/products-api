<?php
namespace Router;

use App\Dtos\Response;

class RouterUtils
{

    public static function makeResponse($response, $status): void
    {
        header('X-powered-by: Micro router');
        http_response_code($status);

        if ($status < 500) {
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            echo $response;
        }
    }

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

        return [$handler, $request];
    }


    private static function getBody()
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