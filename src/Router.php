<?php

class Router
{
    private array $routes = [];

    private Request $request;

    public function add(
        string $path,
        string $controller,
        string $method = 'GET',
    ): void
    {
        $this->routes[$path][$method] = $controller;
    }

    public function match(
        Request $request,
    ): bool
    {
        if ($this->routes === []) {
            return false;
        }

        $this->request = $request;

        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        if (isset($this->routes[$path][$method])) {
            return true;
        }

        return false;
    }

    public function controller()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        return $this->routes[$path][$method];
    }

    public function action()
    {
        return $this->request->getMethod();
    }
}
