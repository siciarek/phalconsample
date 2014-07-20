<?php

// Set the database service
$di->set('db', function () use ($di) {
    return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        'host' => $di->get('config')->database->host,
        'username' => $di->get('config')->database->username,
        'password' => $di->get('config')->database->password,
        'dbname' => $di->get('config')->database->dbname,
        'charset' => $di->get('config')->database->charset,
        'options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "utf8"',
            PDO::ATTR_CASE => PDO::CASE_LOWER
        )
    ));
});

