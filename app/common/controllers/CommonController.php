<?php
namespace Application\Common\Controllers;

abstract class CommonController extends \Phalcon\Mvc\Controller
{

    /**
     * @param \Phalcon\Mvc\Model\Query\Builder $builder
     * @return \Application\Common\Paginator\Pager
     */
    public function createPager(\Phalcon\Mvc\Model\Query\Builder $builder, $pageParam = 'page', $orderParam = 'order')
    {
        $order = $this->request->get($orderParam, array('trim', 'string'));

        $urlMask = '?page={%page_number}';

        if ($order) {
            $list = explode(':', $order);

            if (count($list) === 2) {
                $field = array_shift($list);
                $dir = array_shift($list);
                $dir = strtolower($dir);

                if (preg_match('/^[\w\.]+$/', $field) and in_array($dir, array('asc', 'desc'))) {
                    $urlMask .= sprintf('&%s=%s:%s', $orderParam, $field, $dir);
                    $orderBy = sprintf('%s %s', $field, $dir);
                    $builder->orderBy($orderBy);
                }
            }
        }

        $paginator = new \Phalcon\Paginator\Adapter\QueryBuilder(array(
            'builder' => $builder,
            'limit' => $this->config->pager->size,
            'page' => $this->request->get($pageParam, array('int')),
        ));

        $pager = new \Phalcon\Paginator\Pager(
            $paginator,
            array(
                'layoutClass' => 'Application\Common\Paginator\Pager\Layout\Bootstrap',
                'rangeLength' => $this->config->pager->length,
                'urlMask' => $urlMask,
            )
        );
        return $pager;
    }

    /**
     * @return mixed
     */
    public function sendJson($data = null, $type = 'info', $msg = null, $recordsTotal = null)
    {
        $frame = $this->getFrame($data, $type, $msg, $recordsTotal);

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
    public function getFrame($data, $type = 'info', $msg = null, $recordsTotal = null)
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
            $frame['totalCount'] = $recordsTotal === null ? count($data) : $recordsTotal;
            $frame['recordsTotal'] = $recordsTotal === null ? count($data) : $recordsTotal;
        }

        if($msg !== null) {
            $frame['msg'] = $msg;
        }

        return $frame;
    }
}
