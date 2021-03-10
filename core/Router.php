<?php

namespace core;

use core\helpers\Debug;

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
     * Current route.
     *
     * @var array
     */
    public $route = [];

    /**
     * Current route parameters.
     *
     * @var array
     */
    public $params = [];

    /**
     * Loads the registered routes.
     *
     * @return void
     */
    private function load()
    {
        $routes = require 'config/routes.php';

        foreach ($routes as $route) {
            $route['url'] = '/^' . \str_replace('/', '\/', $route['url']) . '$/';

            $this->routes[] = $route;
        }
    }

    /**
     * Finds out if the visited url exists in routes.
     *
     * @return boolean
     */
    public function match() : bool
    {
        $url = $_SERVER['REQUEST_URI'];

        foreach ($this->routes as $route) {
            if (\preg_match($route['url'], $url, $params)) {
                if ($route['method'] == $_SERVER['REQUEST_METHOD']) {
                    \array_shift($params);

                    $this->route  = $route;
                    $this->params = $params;

                    return true;
                }
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
            $path = 'api\\' . $this->route['class'];
            
            if (class_exists($path)) {
                $action = $this->route['action'];

                if (method_exists($path, $action)) {
                    $api = new $path($this->params);
                    $api->$action();
                }
            } 
        }
    }
}