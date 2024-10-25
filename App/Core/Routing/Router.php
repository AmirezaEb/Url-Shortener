<?php

namespace App\Core\Routing;

use App\Core\Request;
use Exception;

class Router
{
    private $request;       # Stores the current request object
    private $routes;        # Stores all the defined routes
    private $currentRoute;  # Stores the current matched route, if any
    const NAMESPACE = 'App\Controllers\\';  # Controller namespace for routing

    /**
     * Router constructor.
     * Initializes the request object and fetches the defined routes.
     * Attempts to match the current request to a route.
     */
    public function __construct()
    {
        $this->request = new Request();           # Instantiate the Request object
        $this->routes = Route::routers();         # Fetch all defined routes
        $this->currentRoute = $this->findRoute($this->request) ?? null;  # Find the matching route or set to null
    }

    /**
     * Find a matching route for the given request.
     *
     * @param Request $request The current request
     * @return array|null The matched route or null if no match
     */
    private function findRoute(Request $request): array|null
    {
        foreach ($this->routes as $route) {
            # Match the HTTP method
            if ($request->method() == $route['method']) {
                # Check for dynamic parameters in the URI
                if (strpos($route['uri'], '{') !== false) {
                    # Create a regex pattern to match dynamic parameters in the URI
                    $pattern = "/^" . str_replace(['/', '{', '}'], ['\/', '(?<', '>[a-zA-Z0-9-]+)'], $route['uri']) . "$/";
                    if (preg_match($pattern, $request->uri(), $matches)) {
                        # Add dynamic parameters to the request
                        foreach ($matches as $key => $value) {
                            if (is_string($key) && is_string($value)) {
                                $request->addParam($key, $value);
                            }
                        }
                        return $route;  # Return the matched route
                    }
                } else {
                    # Exact URI match
                    if ($request->uri() == $route['uri']) {
                        return $route;  # Return the matched route
                    }
                }
            }
        }
        return null;  # Return null if no route matches
    }

    /**
     * Check if the request has a valid URI but an invalid method (405 Method Not Allowed).
     *
     * @param Request $request The current request
     * @return bool True if the URI is found but the method is invalid
     */
    private function invalidRequest(Request $request): bool
    {
        $foundRoute = false;
        foreach ($this->routes as $route) {
            # Convert route URI patterns to regex
            $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '([a-zA-Z0-9-]+)', $route['uri']);
            if (preg_match("#^$pattern$#", $request->uri())) {
                if ($request->method() != $route['method']) {
                    $foundRoute = true;  # URI found but method does not match
                }
            }
        }
        return $foundRoute;  # Return true if method mismatch is found
    }

    /**
     * Dispatch the matched route.
     *
     * @throws Exception If the class or method does not exist
     */
    private function dispatch(): void
    {
        $action = $this->currentRoute['action'];

        if (is_null($action) || empty($action)) {
            return;  # If no action is defined, return early
        }

        if (is_callable($action)) {
            $action();  # Execute callable actions
        }

        if (is_string($action)) {
            $action = explode('@', $action);  # Split controller and method by '@'
            $action[0] = self::NAMESPACE . $action[0];  # Prepend the namespace to the controller
        }

        if (is_array($action)) {
            $className = $action[0];
            $methodName = $action[1];

            # Throw an exception if the class does not exist
            if (!class_exists($className)) {
                throw new Exception("Class '$className' Not Exists");
            }

            $controller = new $className();  # Instantiate the controller

            # Throw an exception if the method does not exist
            if (!method_exists($controller, $methodName)) {
                throw new Exception("Method '$methodName' Not Exists In Class '$className'");
            }

            # Call the controller method and pass the request
            $controller->{$methodName}($this->request);
        }
    }

    /**
     * Dispatch a 404 Not Found response if no route matches.
     */
    private function dispatch404(): void
    {
        header("HTTP/1.1 404 Not Found");
        view('errors.404');  # Display the 404 error view
        die();
    }

    /**
     * Dispatch a 405 Method Not Allowed response if the method is invalid.
     */
    private function dispatch405(): void
    {
        header("HTTP/1.1 405 Method Not Allowed");
        view('errors.405');  # Display the 405 error view
        die();
    }

    /**
     * Run the router to handle the request and route matching.
     */
    public function run(): void
    {
        # Check for invalid requests (URI exists but method is invalid)
        if ($this->invalidRequest($this->request) && !$this->currentRoute) {
            $this->dispatch405();  # Dispatch 405 if method does not match
            die();
        }

        # If no route is matched, dispatch 404
        if (is_null($this->currentRoute)) {
            $this->dispatch404(); # Dispatch 404 if route is not found
        }

        # Dispatch the matched route
        $this->dispatch();
    }
}

?>