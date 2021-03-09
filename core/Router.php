<?php

namespace core;

use helpers\Debug;

/**
 * Router functionality class.
 */
class Router
{
    /**
     * Registered routes.
     *
     * @var array
     */
    public $routes = [];

    /**
     * Loads the registered routes.
     *
     * @return void
     */
    private function load()
    {
        $routes = require 'config/routes.php';

        foreach ($routes as $route => $params) {
            $this->add($route, $params);
        }
    }

    /**
     * Adds the regexp modified routes to local routes storage.
     *
     * @param  string $route  - Route that needs adding to router.
     * @param  array  $params - Route params that needs adding to router.
     * @return void
     */
    private function add(string $route, array $params)
    {
        $route = '#^' . $route . '$#';

        $this->routes[$route] = $params;
    }

    /**
     * Finds out if the visited url exists in routes.
     *
     * @return boolean
     */
    public function match() : bool
    {
        $url = $_SERVER['REQUEST_URI'];

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $params;

                return true;  
            } 
        }

        return false;
    }

    /**
     * Executes router.
     *
     * @return void
     */
    public function execute()
    {
        $this->load();
        
        if ($this->match()) {
            $path = 'api\\' . $this->params['class'];
            
            if (class_exists($path)) {
                $action = 'execute';

                if (method_exists($path, $action)) {
                    $api = new $path();
                    $api->$action();
                } 
            } 
        }
    }
}