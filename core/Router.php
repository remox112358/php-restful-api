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
     * Adds the route in list of routes.
     *
     * @param  string $url    - URL of route.
     * @param  string $path   - Path to callback action.
     * @param  string $method - Request HTTP method.
     * @return void
     */
    private static function add(string $url, string $path, string $method)
    {
        $route = [
            'url'    => '/^' . \str_replace('/', '\/', $url) . '$/',
            'class'  => \explode('@', $path)[0],
            'action' => \explode('@', $path)[1],
            'method' => $method,
        ];

        self::$routes[] = $route;
    }

    /**
     * Adds the route with GET method to list.
     *
     * @param  string $url  - URL of route.
     * @param  string $path - Path to callback action.
     * @return void
     */
    public static function get(string $url, string $path)
    {
        self::add($url, $path, 'GET');
    }

    /**
     * Adds the route with POST method to list.
     *
     * @param  string $url  - URL of route.
     * @param  string $path - Path to callback action.
     * @return void
     */
    public static function post(string $url, string $path)
    {
        self::add($url, $path, 'POST');
    }

    /**
     * Adds the route with PUT method to list.
     *
     * @param  string $url  - URL of route.
     * @param  string $path - Path to callback action.
     * @return void
     */
    public static function put(string $url, string $path)
    {
        self::add($url, $path, 'PUT');
    }

    /**
     * Adds the route with PATCH method to list.
     *
     * @param  string $url  - URL of route.
     * @param  string $path - Path to callback action.
     * @return void
     */
    public static function patch(string $url, string $path)
    {
        self::add($url, $path, 'PATCH');
    } 

    /**
     * Adds the route with DELETE method to list.
     *
     * @param  string $url  - URL of route.
     * @param  string $path - Path to callback action.
     * @return void
     */
    public static function delete(string $url, string $path)
    {
        self::add($url, $path, 'DELETE');
    }

    /**
     * Finds out if the visited url exists in routes.
     *
     * @return bool
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