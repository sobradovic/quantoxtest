<?php

namespace App\Http;

use Klein\Klein;

class Router
{
    protected $klein;

    public function __construct()
    {
        $this->klein = new Klein;
    }

    public function register(string $requestMethod, string $path, string $callback)
    {
        $segments = explode('@', $callback);
        $className = $segments[0];
        $classMethod = $segments[1];

        return $this->klein->respond($requestMethod, $path, function ($request, $response) use ($className, $classMethod) {
            $class = new $className();

            return $class->$classMethod($request, $response);
        });
    }

    public function dispatch()
    {
        return $this->klein->dispatch();
    }
}
