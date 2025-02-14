<?php
class RouterUtils
{
    public static function getBody()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    public static function makeResponse($response, $status = 200): void
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
}