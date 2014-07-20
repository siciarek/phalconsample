<?php
namespace Application\Backend\Entity;

use Application\Backend\Model\Timestampable;

class Group extends \Phalcon\Mvc\Model
{
    public $name;

    public $description;

    public function initialize()
    {
        $this->hasManyToMany(
            'id',
            'Application\Backend\Entity\UserGroup',
            'group_id',
            'user_id',
            'Application\Backend\Entity\User',
            'id',
            array('alias' => 'users')
        );

        $this->addBehavior(new \Phalcon\Mvc\Model\Behavior\Timestampable(
            array(
                'beforeCreate' => array(
                    'field' => 'created_at',
                    'format' => 'Y-m-d H:i:s'
                )
            )
        ));
    }

    public function validation()
    {
        $this->validate(new PresenceOf(array(
                'field' => 'name',
                'message' => 'group.error.no_name'
            ))
        );

        $this->validate(new StringLength(array(
                'field' => 'name',
                'max' => 64,
                'messageMaximum' => 'group.error.too_long_name',
            ))
        );

        $this->validate(new StringLength(array(
                'field' => 'description',
                'max' => 255,
                'messageMaximum' => 'group.error.too_long_description',
            ))
        );
    }
}
