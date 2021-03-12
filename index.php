<?php

use core\Router;

/**
 * Class autoloader.
 */
spl_autoload_register(function($class) {
    $path = str_replace('\\', '/', $class . '.php');
    
    if (file_exists($path)) {
        require $path;
    }
});

/**
 * API routes.
 */
Router::get('/articles', 'Article@index');
Router::get('/articles/(\d+)', 'Article@show');
Router::post('/articles', 'Article@store');
Router::put('/articles/(\d+)', 'Article@update');
Router::delete('/articles/(\d+)', 'Article@destroy');

Router::execute();