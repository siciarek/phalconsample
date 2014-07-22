<?php
namespace Application\Common\ORM\Behaviors;

use Phalcon\Mvc\ModelInterface,
    Phalcon\Mvc\Model\Behavior,
    Phalcon\Mvc\Model\BehaviorInterface;

class Sluggable extends Behavior implements BehaviorInterface
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
            $model->slug = \Phalcon\Utils\Slug::generate(implode('-', $model->getSluggableValues()));
        }

        if ($eventType == 'beforeUpdate') {
            $model->slug = \Phalcon\Utils\Slug::generate(implode('-', $model->getSluggableValues()));
        }
    }
}