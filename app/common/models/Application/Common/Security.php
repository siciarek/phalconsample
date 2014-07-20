<?php

namespace Application\Common;

class Security extends \Phalcon\Security
{
    public function hash($password, $workFactor = NULL)
    {
        return md5($password);
    }

    public function checkHash($password, $passwordHash, $maxPasswordLength = NULL)
    {
        if ($passwordHash === md5($password)) {
            return true;
        }

        return false;
    }
}