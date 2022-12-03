<?php

class Router
{
    private array $routes = [];

    private Request $lastRequest;

    public function add(string $path, string $controller, $method = 'GET')
    {
        $this->routes[$path][$method] = $controller; 
    }

    public function match(Request $request)
    {
        if ($this->routes === []) {
            return false;
        }

        $this->lastRequest = $request;
        return isset($this->routes[$request->getPath()][$request->getMethod()]);
    }

    public function controller(): string
    {
        return $this->routes[$this->lastRequest->getPath()][$this->lastRequest->getMethod()];
    }

    public function action(): string
    {
        return $this->lastRequest->getMethod();
    }
}
