<?php

require_once __DIR__ . '/../vendor/autoload.php';

class HomeController
{
    public function get()
    {
        echo 'pagina web';
    }
}

$router = new Router();
$router->add('/', HomeController::class);
if ($router->match(new Request())) {
    echo '< HTTP/2 200<br>< Pagina trovata';
    $controller = $router->controller();
    $action = $router->action();
    $page = new $controller();
    $method = strtolower($action);
    $page->$method();
} else {
    echo '< HTTP/2 404<br>< Pagina non trovata';
}
