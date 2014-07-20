<?php

$di->set('security', function () use ($di) {

    $security = new Application\Common\Security();

    //Set the password hashing factor to 12 rounds
    $security->setWorkFactor($di->get('config')->security->rounds);

    return $security;
}, true);


$di->set('auth', function() use ($di) {
    $auth = new \Application\Common\Auth($di);

    return $auth;
});