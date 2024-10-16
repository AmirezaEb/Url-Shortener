<?php

namespace App\Core\Routing;

use App\Core\Request;
use Exception;

class Router
{
    private $request;
    private $routes;
    private $currentRoute;
    const NAMESPACE = 'App\Controllers\\';

    public function __construct()
    {
        $this->request = new Request();
        $this->routes = Route::routers();
        $this->currentRoute = $this->findRoute($this->request) ?? null;
    }

    private function findRoute(Request $request): array|null
    {
        foreach ($this->routes as $route) {
            if ($request->method() == $route['method']) {
                if (strpos($route['uri'], '{') !== false) {
                    $pattern = "/^" . str_replace(['/', '{', '}'], ['\/', '(?<', '>[a-zA-z0-9-]+)'], $route['uri']) . "$/";
                    if (preg_match($pattern, $request->uri(), $matches)) {
                        foreach ($matches as $key => $value) {
                            if (is_string($key) && is_string($value)) {
                                $request->AddParams($key, $value);
                            }
                        }
                        return $route;
                    }
                } else {
                    if ($request->uri() == $route['uri']) {
                        return $route;
                    }
                }
            }
        }
        return null;
    }

    private function invalidRequest(Request $request): bool
    {
        $foundRoute = false;
        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '([a-zA-Z0-9-]+)', $route['uri']);
            if (preg_match("#^$pattern$#", $request->uri())) {
                if ($request->method() != $route['method']) {
                    $foundRoute = true;
                }
            }
        }
        return $foundRoute;
    }

    private function dispatch() :void
    {
        $action = $this->currentRoute['action'];
        if (is_null($action) || empty($action)) {
            return;
        }

        if (is_callable($action)) {
            $action();
        }

        if (is_string($action)) {
            $action = explode('@', $action);
            $action[0] = self::NAMESPACE . $action[0];
        }

        if (is_array($action)) {
            $className = $action[0];
            $methodName = $action[1];

            if (!class_exists($className)) {
                throw new \Exception("Class '$className' Not Exists");
            }

            $controller = new $className();

            if (!method_exists($className, $methodName)) {
                throw new \Exception("Method '$methodName' Not Exists In Class '$className'");
            }
            $controller->{$methodName}($this->request);
        }
    }

    private function despatch404(): void
    {
        header("HTTP/1.1 404 Not Found");
        view('errors.404');
        die();
    }

    private function despatch405(): void
    {
        header("HTTP/1.1 405 Method Not Allowed");
        view('errors.405');
        die();
    }

    public function run(): void
    {
        if ($this->invalidRequest($this->request) && !$this->currentRoute){
            // echo ;
            $this->despatch405();
            die();
        }

        if (is_null($this->currentRoute)) {
            $this->despatch404();
        }

        $this->dispatch();
    }
}
