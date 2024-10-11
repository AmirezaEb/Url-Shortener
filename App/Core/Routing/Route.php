<?php

namespace App\Core\Routing;

use Closure;

class Route
{
    private static $routes = [];

    public static function add(string $method, string $uri, $action = null): void
    {
        self::$routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action
        ];
    }

    public static function run(): void
    {
        include BASEPATH . 'routes/web.php';
    }

    public static function get(string $uri, array|Closure|string $action = null): void
    {
        self::add('get', $uri, $action);
    }

    public static function post(string $uri, array|Closure|string $action = null): void
    {
        self::add('post', $uri, $action);
    }

    public static function put(string $uri, array|Closure|string $action = null): void
    {
        self::add('put', $uri, $action);
    }

    public static function delete(string $uri, array|Closure|string $action = null): void
    {
        self::add('delete', $uri, $action);
    }

    public static function options(string $uri, array|Closure|string $action = null): void
    {
        self::add('options', $uri, $action);
    }

    public static function patch(string $uri, array|Closure|string $action = null): void
    {
        self::add('put', $uri, $action);
    }

    public static function routers(): array
    {
        return self::$routes;
    }
}
