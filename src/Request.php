<?php

class Request
{
    public function getPath(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

}
