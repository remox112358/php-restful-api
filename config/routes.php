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
        'url'    => '/articles/(\d+)',
        'class'  => 'Articles',
        'action' => 'show',
        'method' => 'GET',
    ],
    [
        'url'    => '/articles',
        'class'  => 'Articles',
        'action' => 'store',
        'method' => 'POST',
    ],
    [
        'url'    => '/articles/(\d+)',
        'class'  => 'Articles',
        'action' => 'update',
        'method' => 'PUT',
    ]
];