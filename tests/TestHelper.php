<?php
use Phalcon\DI,
    Phalcon\DI\FactoryDefault;

ini_set('display_errors',1);
error_reporting(E_ALL);

defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../app'));

$di = new FactoryDefault();
DI::reset();

include_once APPLICATION_PATH . '/config/config.php';
include_once APPLICATION_PATH . '/config/databases.php';
include_once APPLICATION_PATH . '/config/view.php';
include_once APPLICATION_PATH . '/config/routing.php';
include_once APPLICATION_PATH . '/config/translations.php';
include_once APPLICATION_PATH . '/config/filters.php';
include_once APPLICATION_PATH . '/config/loader.php';
include_once APPLICATION_PATH . '/config/security.php';
include_once APPLICATION_PATH . '/config/events.php';
// required for phalcon/incubator
include __DIR__ . "/../vendor/autoload.php";



// add any needed services to the DI here

DI::setDefault($di);