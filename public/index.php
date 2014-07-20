<?php

use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;

$debug = new \Phalcon\Debug();
$debug->listen();

try {

    $di = new FactoryDefault();

    include __DIR__ . "/../vendor/autoload.php";
    include_once __DIR__ . '/../app/config/config.php';

    include_once APPLICATION_PATH . '/config/databases.php';
    include_once APPLICATION_PATH . '/config/view.php';
    include_once APPLICATION_PATH . '/config/routing.php';
    include_once APPLICATION_PATH . '/config/translations.php';
    include_once APPLICATION_PATH . '/config/filters.php';
    include_once APPLICATION_PATH . '/config/loader.php';
    include_once APPLICATION_PATH . '/config/security.php';
    include_once APPLICATION_PATH . '/config/events.php';

    //Create an application
    $application = new Application($di);

    // Register the installed modules
    $application->registerModules(
        array(
            'common' => array(
                'className' => 'Application\Common\Module',
                'path' => APPLICATION_PATH . '/common/Module.php',
            ),
            'frontend' => array(
                'className' => 'Application\Frontend\Module',
                'path' => APPLICATION_PATH . '/frontend/Module.php',
            ),
            'backend' => array(
                'className' => 'Application\Backend\Module',
                'path' => APPLICATION_PATH . '/backend/Module.php',
            )
        )
    );

    // Set up debug bar
    if ($config->application->env === 'dev') {
        $debugWidget = new \PDW\DebugWidget($di);
    }

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo '<pre>';
    echo get_class($e), ": ", $e->getMessage(), "\n";
    echo " File=", $e->getFile(), "\n";
    echo " Line=", $e->getLine(), "\n";
    echo $e->getTraceAsString();
}
