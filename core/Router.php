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
    private static $routes = [];

    /**
     * Current route.
     *
     * @var array
     */
    public static $route = [];

    /**
     * Current route parameters.
     *
     * @var array
     */
    public static $params = [];

    /**
     * Disable class creation and copy.
     */
    private function __construct() {}
    private function __clone() {}

    /**
     * Loads the registered routes.
     *
     * @return void
     */
    private static function load()
    {
        $routes = require 'config/routes.php';

        foreach ($routes as $route) {
            $route['url'] = '/^' . \str_replace('/', '\/', $route['url']) . '$/';

            self::$routes[] = $route;
        }
    }

    /**
     * Adds the route to list.
     *
     * @param  string $url  - URL of route.
     * @param  string $path - Path to callback action.
     * @return void
     */
    private static function add(string $url, string $path)
    {
        Debug::show($url);
        Debug::show($path, true);
    }

    /**
     * Finds out if the visited url exists in routes.
     *
     * @return boolean
     */
    public static function match() : bool
    {
        $url = $_SERVER['REQUEST_URI'];

        foreach (self::$routes as $route) {
            if (\preg_match($route['url'], $url, $params)) {
                if ($route['method'] == $_SERVER['REQUEST_METHOD']) {
                    \array_shift($params);

                    self::$route  = $route;
                    self::$params = $params;

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
    public static function execute()
    {
        self::load();
        
        if (self::match()) {
            $path = 'api\\' . self::$route['class'];
            
            if (class_exists($path)) {
                $action = self::$route['action'];

                if (method_exists($path, $action)) {
                    $api = new $path(self::$params);
                    $api->$action();
                }
            } 
        }
    }
}