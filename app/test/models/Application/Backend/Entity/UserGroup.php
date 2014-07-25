<?php
namespace Application\Backend\Entity;

class UserGroup extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->belongsTo('user_id', 'Application\Backend\Entity\User', 'id',
            array('alias' => 'user', 'foreignKey' => array(
                'user.error.no_such_user',
            )));
        $this->belongsTo('group_id', 'Application\Backend\Entity\Group', 'id',
            array('alias' => 'group', 'foreignKey' => array(
                'group.error.no_such_group',
            )));

        $this->skipAttributes(array('created_at'));
    }
}
