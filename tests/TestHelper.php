<?php
use Phalcon\DI,
    Phalcon\DI\FactoryDefault;

ini_set('display_errors',1);
error_reporting(E_ALL);

defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../apps'));

include __DIR__ . '/../apps/config/loader.php';

// required for phalcon/incubator
include __DIR__ . "/../vendor/autoload.php";


$di = new FactoryDefault();
DI::reset();

// add any needed services to the DI here

DI::setDefault($di);