<?php
use Phalcon\DI,
    \Phalcon\Test\UnitTestCase as PhalconTestCase;

class CommonController extends Application\Common\Controllers\CommonController
{

}

class CommonControllerTest extends PhalconTestCase
{

    protected $di;
    protected $controller;
    /**
     * @var bool
     */
    private $_loaded = false;

    public function testGetFrame()
    {

        $expected = array(
            'info' => array(
                'success' => true,
                'type' => 'info',
                'datetime' => date('Y-m-d H:i:s'),
                'msg' => 'OK',
                'data' => new \stdClass(),
            ),
            'error' => array(
                'success' => false,
                'type' => 'error',
                'datetime' => date('Y-m-d H:i:s'),
                'msg' => 'Error',
                'data' => new \stdClass(),
            ),
            'warning' => array(
                'success' => false,
                'type' => 'warning',
                'datetime' => date('Y-m-d H:i:s'),
                'msg' => 'Warning',
                'data' => new \stdClass(),
            ),
            'data' => array(
                'success' => true,
                'type' => 'data',
                'datetime' => date('Y-m-d H:i:s'),
                'msg' => 'Data',
                'totalCount' => 0,
                'data' => array(),
            )
        );

        $this->assertEquals(
            $expected['info'],
            $this->controller->getFrame(null),
            'Frames are not equal.'
        );

        $this->assertEquals(
            $expected['info'],
            $this->controller->getFrame(null, 'info'),
            'Frames are not equal.'
        );

        $this->assertEquals(
            $expected['error'],
            $this->controller->getFrame(null, 'error'),
            'Frames are not equal.'
        );

        $this->assertEquals(
            $expected['warning'],
            $this->controller->getFrame(null, 'warning'),
            'Frames are not equal.'
        );

        $msg = 'Customized message';
        $e = $expected['info'];
        $e['msg'] = $msg;

        $this->assertEquals(
            $e,
            $this->controller->getFrame(null, 'info', $msg),
            'Frames are not equal.'
        );

        $data = array('code' => 440);
        $e['data'] = $data;
        $this->assertEquals(
            $e,
            $this->controller->getFrame($data, 'info', $msg),
            'Frames are not equal.'
        );
//
//        $data = array(1, 2, 3, 4);
//        $e = $expected['data'];
//        $e['data'] = $data;
//        $e['totalCount'] = count($data);
//        $this->assertEquals(
//            $e,
//            $this->controller->getFrame($data, 'data'),
//            'Frames are not equal.'
//        );
    }

    public function setUp(Phalcon\DiInterface $di = NULL, Phalcon\Config $config = NULL)
    {

        // Load any additional services that might be required during testing
        $this->di = DI::getDefault();

        // get any DI components here. If you have a config, be sure to pass it to the parent
        parent::setUp($this->di);

        $this->controller = new CommonController();

        $this->_loaded = true;
    }

    /**
     * Check if the test case is setup properly
     * @throws \PHPUnit_Framework_IncompleteTestError;
     */
    public function __destruct()
    {
        if (!$this->_loaded) {
            throw new \PHPUnit_Framework_IncompleteTestError('Please run parent::setUp().');
        }
    }
}