<?php

// Cette classe permet le routage des requêtes arrivant vers index.php
// en fonction de leur méthode et paramètres
class Router
{
    private $verb;
    private $route;
    private $postData;

    public function __construct()
    {
        $this->verb = $_SERVER['REQUEST_METHOD'];
        $this->route = $_SERVER['REQUEST_URI'];
        $this->postData = $_POST;
    }

    public function get($route, $callback)
    {
        if ($this->verb == 'GET' && $this->route == $route) {
            return $callback();
        }
    }

    public function post($route, $callback)
    {
        if ($this->verb == 'POST' && $this->route == $route) {
            return $callback($this->postData);
        }
    }

    public function redirect($location)
    {
        header("Location: {$location}");
        die();
    }
}