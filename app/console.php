<?php

use Phalcon\DI\FactoryDefault\CLI as CliDI,
    Phalcon\CLI\Console as ConsoleApp;

define('VERSION', '1.0.0');

//Using the CLI factory default services container
$di = new CliDI();

// Define path to application directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__)));

include_once APPLICATION_PATH . '/config/config.php';
include_once APPLICATION_PATH . '/config/view.php';
include_once APPLICATION_PATH . '/config/routing-cli.php';
include_once APPLICATION_PATH . '/config/databases.php';
include_once APPLICATION_PATH . '/config/translations.php';
include_once APPLICATION_PATH . '/config/filters.php';
include_once APPLICATION_PATH . '/config/loader.php';

//Create a console application
$application = new ConsoleApp();
$application->setDI($di);

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

$view = $di->get('view');

$application->registerModules(
    array(
        'frontend' => function ($di) use ($view) {
            $di->setShared('view', function () use ($view) {
                $view->setViewsDir(APPLICATION_PATH . '/frontend/views/');
                return $view;
            });
        },
        'backend' => function ($di) use ($view) {
            $di->setShared('view', function () use ($view) {
                $view->setViewsDir(APPLICATION_PATH . '/backend/views/');
                return $view;
            });
        },
        'common' => function ($di) use ($view) {
            $di->setShared('view', function () use ($view) {
                $view->setViewsDir(APPLICATION_PATH . '/common/views/');
                return $view;
            });
        },
    )
);

$di->setShared('console', $application);

/**
 * Process the console arguments
 */
$arguments = array();

foreach ($argv as $k => $arg) {
    if ($k == 1) {
        $arguments['task'] = $arg;
    } elseif ($k == 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments[] = $arg;
    }
}

// define global constants for the current task and action
define('CURRENT_TASK', (isset($argv[1]) ? $argv[1] : null));
define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));

try {
    // handle incoming arguments
    $application->handle($arguments);
} catch (\Phalcon\Exception $e) {
    echo $e->getMessage();
    exit(255);
}
