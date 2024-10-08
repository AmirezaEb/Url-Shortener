<?php

namespace App\Core\Routing;

use App\Core\Request;
use Exception;

class Router
{
    private $request;
    private $routes;
    private $currentRoute;
    const NAMESPACE = 'App\Controllers\\' ;

    public function __construct()
    {
        $this->request = new Request();
        $this->routes = Route::routers();
        $this->currentRoute = $this->findRoute($this->request) ?? null;
    }

    private function findRoute(Request $request): array|null
    {
        foreach ($this->routes as $route) {
            if ($request->method() == $route['method'] && $request->uri() == $route['uri']) {
                return $route;
            }
        }
        return null;
    }

    private function invalidRequest(Request $request): bool
    {
        $foundRoute = false;
        foreach ($this->routes as $route) {
            if ($request->uri() == $route['uri']) {
                $foundRoute = true;
                if($request->method() == $route['method']){
                    return false;
                }
                return true;
            }
        }
        return $foundRoute;
    }

    private function dispatch()
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
            
            if(!method_exists($className,$methodName)){
                throw new \Exception("Method '$methodName' Not Exists In Class '$className'");
            }
            
            $controller->{$methodName}();
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
        if ($this->invalidRequest($this->request) && !$this->currentRoute) {
            $this->despatch405();
            die();
        }

        if (is_null($this->currentRoute)) {
            $this->despatch404();
        }

        $this->dispatch();
    }
}
