<?php

namespace App\Core;

class Request
{
    private $params;  # Holds request parameters
    private $method;  # HTTP request method (GET, POST, etc.)
    private $agent;   # User agent string of the client
    private $uri;     # Request URI without query string
    private $ip;      # IP address of the client

    /**
     * Request constructor initializes properties from superglobals
     */
    public function __construct()
    {
        $this->params = $_REQUEST;  # Retrieve all request parameters
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);  # Get HTTP method and convert to lowercase
        $this->agent = $_SERVER['HTTP_USER_AGENT'];  # Get user agent
        $this->uri = strtok($_SERVER['REQUEST_URI'], '?');  # Get URI excluding query string
        $this->ip = $_SERVER['REMOTE_ADDR'];  # Get client IP address
    }

    /**
     * Add a new parameter to the request
     *
     * @param string $property The parameter name
     * @param string $value The value of the parameter
     */
    public function addParam(string $property, string $value): void
    {
        $this->params[$property] = $value;  # Set parameter in the params array
    }

    /**
     * Check if a parameter exists in the request
     *
     * @param string $key The parameter name
     * @return bool True if the parameter exists, false otherwise
     */
    public function has(string $key): bool
    {
        return isset($this->params[$key]);  # Return true if parameter exists
    }

    /**
     * Get the value of a specific parameter
     *
     * @param string $key The parameter name
     * @return string The value of the parameter
     * @throws \InvalidArgumentException if the parameter does not exist
     */
    public function param(string $key): string
    {
        if (!$this->has($key)) {
            throw new \InvalidArgumentException("Parameter '$key' does not exist.");  # Throw exception if parameter not found
        }
        return $this->params[$key];  # Return the value of the specified parameter
    }

    /**
     * Get all request parameters as an associative array
     *
     * @return array The request parameters
     */
    public function params(): array
    {
        return $this->params;  # Return all parameters
    }

    /**
     * Get the HTTP method used for the request
     *
     * @return string The HTTP method
     */
    public function method(): string
    {
        return $this->method;  # Return the request method
    }

    /**
     * Get the user agent string of the client
     *
     * @return string The user agent
     */
    public function agent(): string
    {
        return $this->agent;  # Return the user agent string
    }

    /**
     * Get the request URI without query string
     *
     * @return string The request URI
     */
    public function uri(): string
    {
        return $this->uri;  # Return the request URI
    }

    /**
     * Get the IP address of the client
     *
     * @return string The client IP address
     */
    public function ip(): string
    {
        return $this->ip;  # Return the client IP address
    }
}