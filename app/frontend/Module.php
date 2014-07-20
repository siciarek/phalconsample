<?php

namespace Application\Frontend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;

class Module implements ModuleDefinitionInterface
{
    /**
     * Register a specific autoloader for the module
     */
    public function registerAutoloaders()
    {

    }

    /**
     * Register specific services for the module
     */
    public function registerServices($di)
    {
        $view = $di->get('view');

        $di->setShared('view', function () use ($view) {
            $view->setViewsDir(APPLICATION_PATH . '/frontend/views/');
            return $view;
        });

        $di->set('dispatcher', function() use ($di) {
            return $di->get('common_dispatcher');
        });
    }
}
