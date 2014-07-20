<?php

$di->set('router', function () {
    $router = new \Phalcon\Mvc\Router\Annotations();

    $router->addModuleResource('frontend', 'Application\Frontend\Controllers\Default');
    $router->addModuleResource('frontend', 'Application\Frontend\Controllers\Test');

    $router->addModuleResource('backend', 'Application\Backend\Controllers\Admin');

    $router->addModuleResource('common', 'Application\Common\Controllers\Locale');
    $router->addModuleResource('common', 'Application\Common\Controllers\Error');

    return $router;
});
