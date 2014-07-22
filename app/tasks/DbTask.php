<?php

define('MYSQL', 'mysql');

class DbTask extends \Phalcon\CLI\Task
{
    public function mainAction()
    {
        $cmd = sprintf('%s -u"%s" %s -D"%s" < %s',
            MYSQL,
            $this->config->database->username,
            $this->config->database->password ? '-p "' . $this->config->database->password . '"' : '',
            $this->config->database->dbname,
            realpath(APPLICATION_PATH . '/config/schema/query.sql')
        );

        echo `$cmd`;
    }
}
