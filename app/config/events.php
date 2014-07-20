<?php

$di->set('common_dispatcher', function() use ($di) {
    $eventsManager = new Phalcon\Events\Manager();
    $eventsManager->attach('dispatch', new \Application\Common\Plugin\SecurePlugin());
    $dispatcher = new Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($eventsManager);

    $di->get('view')->setVar('app_name', $di->get('config')->application->name);
    $di->get('view')->setVar('trans', $di->get('trans'));
    $di->get('view')->setVar('auth', $di->get('auth'));

    return $dispatcher;
});

