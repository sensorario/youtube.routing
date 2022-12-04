<?php

class Request
{
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getPath()
    {
        return $_SERVER['REQUEST_URI'];
    }
}
