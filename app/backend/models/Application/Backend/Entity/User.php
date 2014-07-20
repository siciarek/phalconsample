<?php
namespace Application\Backend\Entity;

use Application\Backend\Model\Behavior\Blameable;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\Email;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\StringLength;

class User extends \Application\Backend\Model\Person
{
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    /**
     * @var int $id
     */
    public $id;
    public $enabled = 1;
    public $suspended = 0;
    public $roles = array('ROLE_USER');

    public function columnMap()
    {
        // Keys are the real names in the table and
        // the values their names in the application
        return array(
            'id' => 'id',
            'enabled' => 'enabled',
            'suspended' => 'suspended',
            'gender' => 'gender',
            'info' => 'info',
            'password' => 'password',
            'roles' => 'roles',
            'first_name' => 'firstName',
            'last_name' => 'lastName',
            'email' => 'email',
            'created_at' => 'created_at',
            'expires_at' => 'expires_at',
        );
    }

    public function getAllRoles()
    {
        $roles = $this->roles ? : array();

        foreach ($this->groups as $g) {
            $groles = json_decode($g->roles) ? : array();
            $roles = array_unique(array_merge($roles, $groles));
        }

        sort($roles);

        return $roles;
    }

    public function initialize()
    {
        $this->hasMany(
            'id', 'Application\Backend\Entity\UserGroup', 'user_id',
            array('alias' => 'userGroups')
        );

        $this->hasManyToMany(
            'id', 'Application\Backend\Entity\UserGroup', 'user_id',
            'group_id', 'Application\Backend\Entity\Group', 'id',
            array('alias' => 'groups')
        );

        $this->addBehavior(new Blameable());
        $this->addBehavior(new \Phalcon\Mvc\Model\Behavior\Timestampable(
            array(
                'beforeCreate' => array(
                    'field' => 'created_at',
                    'format' => 'Y-m-d H:i:s'
                )
            )
        ));
    }

    public function beforeSave()
    {
        $this->roles = json_encode($this->roles);
    }

    public function afterSave()
    {
        $this->afterFetch();
    }

    public function afterFetch()
    {
        $this->roles = json_decode($this->roles);
    }

    public function validation()
    {
        $this->validate(new PresenceOf(array(
                'field' => 'firstName',
                'message' => 'user.error.no_first_name'
            ))
        );

        $this->validate(new StringLength(array(
                'field' => 'firstName',
                'max' => 127,
                'messageMaximum' => 'user.error.too_long_first_name',
            ))
        );

        $this->validate(new PresenceOf(array(
                'field' => 'lastName',
                'cancelOnFail' => true,
                'message' => 'user.error.no_last_name'
            ))
        );

        $this->validate(new StringLength(array(
                'field' => 'lastName',
                'max' => 127,
                'messageMaximum' => 'user.error.too_long_last_name',
            ))
        );

        $this->validate(new Email(array(
            'field' => 'email',
            'message' => 'user.error.invalid_email',
        )));

        $this->validate(new Uniqueness(array(
            'field' => 'email',
            'message' => 'user.error.email_already_exists',
        )));

        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}
