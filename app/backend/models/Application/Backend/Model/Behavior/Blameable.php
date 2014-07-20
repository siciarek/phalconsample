<?php

namespace Application\Backend\Model\Behavior;

use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\Model\BehaviorInterface;

class Blameable extends Behavior implements BehaviorInterface
{
    public function notify($eventType, $model)
    {
        switch ($eventType) {

            case 'afterCreate':
            case 'afterDelete':
            case 'afterUpdate':

                $userName = $_SESSION['user']->name;
                $logFile = APPLICATION_PATH . '/../blameable.log';
                $logLine = sprintf("[%s] %s %s %s(%s)\n", date('Y-m-d H:i:s'), $userName, $eventType, get_class($model), $model->id);
                file_put_contents($logFile, $logLine, FILE_APPEND);

                break;

            default:
                /* ignore the rest of events */
        }
    }
}