<?php

$loader = new \Phalcon\Loader();

$loader->registerDirs(
    array(
        APPLICATION_PATH . '/../vendor/',
        APPLICATION_PATH . '/common/models/',
        APPLICATION_PATH . '/frontend/models/',
        APPLICATION_PATH . '/backend/models/',
        APPLICATION_PATH . '/test/models/',
        APPLICATION_PATH . '/tasks/',
    )
)->register();

$loader->registerNamespaces(
    array(
        'Application\Common\Controllers'   =>  APPLICATION_PATH . '/common/controllers/',
        'Application\Frontend\Controllers' =>  APPLICATION_PATH . '/frontend/controllers/',
        'Application\Backend\Controllers'  =>  APPLICATION_PATH . '/backend/controllers/',
        'Application\Test\Controllers'  =>  APPLICATION_PATH . '/test/controllers/',
    )
);

$loader->register();
