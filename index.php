<?php

use core\Router;

/**
 * Class autolaoder.
 */
spl_autoload_register(function($class) {
    $path = str_replace('\\', '/', $class . '.php');
    
    if (file_exists($path)) {
        require $path;
    }
});

Router::add('/articles/{id}', 'Articles@show');
Router::execute();