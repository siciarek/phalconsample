<?php
namespace Application\Common\ORM\Behaviors;

use Phalcon\Mvc\ModelInterface,
    Phalcon\Mvc\Model\Behavior,
    Phalcon\Mvc\Model\BehaviorInterface;

class Timestampable extends Behavior implements BehaviorInterface
{
    /**
     * Receives notifications from the Models Manager
     *
     * @param string $eventType
     * @param Phalcon\Mvc\ModelInterface $model
     */
    public function notify($eventType, $model)
    {
        if ($eventType == 'beforeCreate') {
            $model->setCreatedAt(date('Y-m-d H:i:s'));
            $model->setUpdatedAt($model->getCreatedAt());
        }

        if ($eventType == 'beforeUpdate') {
            $model->setUpdatedAt(date('Y-m-d H:i:s'));
        }
    }
}