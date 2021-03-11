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
Router::get('/articles', 'Articles@index');
Router::get('/articles/(\d+)', 'Articles@show');
Router::post('/articles', 'Articles@store');
Router::put('/articles/(\d+)', 'Articles@update');
Router::delete('/articles/(\d+)', 'Articles@destroy');

Router::execute();