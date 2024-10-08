<?php

namespace App\Core;

class Request
{
    private $params;
    private $method;
    private $agent;
    private $uri;
    private $ip;

    public function __construct()
    {
        $this->params = $_REQUEST;
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->agent = $_SERVER['HTTP_USER_AGENT'];
        $this->uri = strtok($_SERVER['REQUEST_URI'], '?');
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    public function params(): array
    {
        return $this->params;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function agent(): string
    {
        return $this->agent;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function ip(): string
    {
        return $this->ip;
    }
}
