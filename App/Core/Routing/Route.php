<?php

namespace App\Core\Routing;

use Closure;

class Route
{
    # Holds all registered routes
    private static array $routes = [];

    /**
     * Add a new route to the routes array.
     *
     * @param string $method HTTP method (GET, POST, etc.)
     * @param string $uri URI pattern for the route
     * @param array|string|Closure|null $action Controller action or closure to handle the route
     */
    public static function add(string $method, string $uri, array|string|Closure $action = null): void
    {
        # Add a new route to the routes array
        self::$routes[] = [
            'method' => strtolower($method),  # Ensure the HTTP method is always lowercase
            'uri' => $uri,                    # Store the route URI
            'action' => $action               # Store the action (controller method or closure)
        ];
    }

    /**
     * Load and register routes from the web.php file.
     * This method typically initializes all routes defined in the application.
     */
    public static function run(): void
    {
        # Include the web.php routes file (contains all route definitions)
        include BASEPATH . 'routes/web.php';
    }

    /**
     * Define a GET route.
     *
     * @param string $uri URI pattern for the GET route
     * @param array|Closure|string|null $action Action to handle the GET request
     */
    public static function get(string $uri, array|Closure|string $action = null): void
    {
        # Register a GET route by calling the add method
        self::add('get', $uri, $action);
    }

    /**
     * Define a POST route.
     *
     * @param string $uri URI pattern for the POST route
     * @param array|Closure|string|null $action Action to handle the POST request
     */
    public static function post(string $uri, array|Closure|string $action = null): void
    {
        # Register a POST route by calling the add method
        self::add('post', $uri, $action);
    }

    /**
     * Define a PUT route.
     *
     * @param string $uri URI pattern for the PUT route
     * @param array|Closure|string|null $action Action to handle the PUT request
     */
    public static function put(string $uri, array|Closure|string $action = null): void
    {
        # Register a PUT route by calling the add method
        self::add('put', $uri, $action);
    }

    /**
     * Define a DELETE route.
     *
     * @param string $uri URI pattern for the DELETE route
     * @param array|Closure|string|null $action Action to handle the DELETE request
     */
    public static function delete(string $uri, array|Closure|string $action = null): void
    {
        # Register a DELETE route by calling the add method
        self::add('delete', $uri, $action);
    }

    /**
     * Define an OPTIONS route.
     *
     * @param string $uri URI pattern for the OPTIONS route
     * @param array|Closure|string|null $action Action to handle the OPTIONS request
     */
    public static function options(string $uri, array|Closure|string $action = null): void
    {
        # Register an OPTIONS route by calling the add method
        self::add('options', $uri, $action);
    }

    /**
     * Define a PATCH route.
     *
     * @param string $uri URI pattern for the PATCH route
     * @param array|Closure|string|null $action Action to handle the PATCH request
     */
    public static function patch(string $uri, array|Closure|string $action = null): void
    {
        # Register a PATCH route by calling the add method
        self::add('patch', $uri, $action);  // Corrected method name to 'patch'
    }

    /**
     * Retrieve all registered routes.
     *
     * @return array An array of all registered routes
     */
    public static function routers(): array
    {
        # Return the array containing all routes
        return self::$routes;
    }
}

