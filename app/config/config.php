<?php

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../app'));

$config = new \Phalcon\Config\Adapter\Ini(APPLICATION_PATH . '/config/config.ini');

$di->set('config', function () use ($config) {
    return $config;
});

$di->set('flash', function () {
    $flash = new \Phalcon\Flash\Session(
        array(
            'error' => 'alert alert-error',
            'notice' => 'alert alert-info',
            'success' => 'alert alert-success',
            'warning' => 'alert alert-warning',
        )
    );
    return $flash;
});


$di->setShared('cache', function () use ($di) {
    $frontCache = new Phalcon\Cache\Frontend\Data();

    $cacheDir = APPLICATION_PATH . $di->get('config')->dirs->cache . '/shared/';

    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0777, true);
    }

    $cache = new Phalcon\Cache\Backend\File($frontCache, array(
        "cacheDir" => $cacheDir,
    ));

    return $cache;
});

//Setup a base URI so that all generated URIs for all the application
$di->setShared('url', function () {
    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri('/');
    return $url;
});

$di->setShared('session', function () use($di) {
    $session = new Phalcon\Session\Adapter\Database(array(
        'db' => $di->get('db'),
        'table' => $di->get('config')->session->table,
    ));

    $session->start();
    return $session;
});

$di->setShared('paginator', function ($builder) use ($di) {
    $curr_page = 1;

    $paginator = new \Phalcon\Paginator\Adapter\QueryBuilder(array(
        'builder' => $builder,
        'limit' => $di->get('config')->application->pager,
        'page' => $curr_page,
    ));

    return $paginator;
});