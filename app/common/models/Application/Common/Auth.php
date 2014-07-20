<?php

namespace Application\Common;

use Application\Backend\Entity\User;

class Auth
{
    protected $di;

    public function __construct($di) {
        $this->di = $di;
    }

    public function logOut() {
        $this->di->get('session')->destroy();
    }

    public function authenticate(User $user) {

        $groups = array();

        $roles = $user->getAllRoles();

        foreach($user->groups as $group) {
            $groups[] = $group->name;
        }

        $token = new \stdClass();
        $token->id = $user->id;
        $token->name = $user->getFullName();
        $token->email = $user->email;
        $token->groups = $groups;
        $token->roles = $roles;

        $this->setUser($token);
    }

    public function setUser($token) {
        $this->di->get('session')->set('user', $token);
    }

    public function getUser() {
        return $this->di->get('session')->get('user');
    }

    public function isAuthenticated() {
        return $this->di->get('session')->has('user') and $this->di->get('session')->get('user') instanceof \stdClass;
    }

    public function hasGranted($role) {
        return $this->isAuthenticated() and in_array($role, $this->getUser()->roles);
    }
}