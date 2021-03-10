<?php

/**
 * API routes.
 */
return [
    [
        'url'    => '/articles',
        'class'  => 'Articles',
        'action' => 'index',
        'method' => 'GET',
    ],
    [
        'url'    => '/articles',
        'class'  => 'Articles',
        'action' => 'store',
        'method' => 'POST',
    ],
];