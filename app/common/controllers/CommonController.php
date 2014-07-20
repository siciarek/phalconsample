<?php
namespace Application\Common\Controllers;

abstract class CommonController extends \Phalcon\Mvc\Controller
{
    /**
     * @return mixed
     */
    public function sendJson($data = null, $type = 'info', $msg = null)
    {
        $frame = $this->getFrame($data, $type, $msg);

        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setContent(json_encode($frame));
        return $this->response->send();
    }

    /**
     * @param $data
     * @param $type
     * @return mixed
     */
    public function getFrame($data, $type = 'info', $msg = null)
    {
        $datetime = date('Y-m-d H:i:s');

        $frames = array(
            'request' => array(
                'success' => true,
                'type' => 'request',
                'datetime' => $datetime,
                'msg' => 'Request',
                'data' => new \stdClass(),
            ),
            'info' => array(
                'success' => true,
                'type' => 'info',
                'datetime' => $datetime,
                'msg' => 'OK',
                'data' => new \stdClass(),
            ),
            'error' => array(
                'success' => false,
                'type' => 'error',
                'datetime' => $datetime,
                'msg' => 'Error',
                'data' => new \stdClass(),
            ),
            'warning' => array(
                'success' => false,
                'type' => 'warning',
                'datetime' => $datetime,
                'msg' => 'Warning',
                'data' => new \stdClass(),
            ),
            'data' => array(
                'success' => true,
                'type' => 'data',
                'datetime' => $datetime,
                'msg' => 'Data',
                'totalCount' => 0,
                'data' => array(),
            )
        );

        $frame = $frames[$type];

        $frame['data'] = $data === null ? ($type === 'data' ? array() : new \stdClass()) : $data;

        if ($type === 'data') {
            $frame['totalCount'] = count($data);
        }

        if($msg !== null) {
            $frame['msg'] = $msg;
        }

        return $frame;
    }
}
