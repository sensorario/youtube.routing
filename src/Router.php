<?php

class Router
{
    private array $routes = [];

    private Request $request;

    private string $controller;

    private string $action;

    public function add(string $method, string $path, string $controller)
    {
        $this->routes[$path][$method] = $controller;
    }

    public function match(Request $request): bool
    {
        if ($this->routes === []) {
            return false;
        }

        $this->request = $request;

        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $found = isset($this->routes[$path][$method]);

        if ($found == true) {
            $this->controller = $this->routes[$path][$method];
            $this->action = strtolower($method);
        }

        return $found;
    }

    public function controller()
    {
        return $this->controller;
    }

    public function action()
    {
        return $this->action;
    }
}
