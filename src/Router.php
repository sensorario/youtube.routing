<?php

class Router
{
    private array $routes = [];

    private string $lastMatch;

    private string $lastMethod;

    public function match(Request $request)
    {
        $method = $request->getMethod();
        return isset($this->routes[$request->getPath()][$method]);
    }

    public function add(
        string $path,
        string $controller,
        string $method = 'GET',
    ): void {
        $this->lastMatch = $path;
        $this->lastMethod = $method;
        $this->routes[$this->lastMatch][$method] = $controller;
    }

    public function controller(): string
    {
        return $this->routes[$this->lastMatch][$this->lastMethod];
    }

    public function action(): string
    {
        return $this->lastMethod;
    }
}
