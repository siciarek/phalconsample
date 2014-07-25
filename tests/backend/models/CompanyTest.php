<?php
use Phalcon\DI,
    \Phalcon\Test\UnitTestCase as PhalconTestCase;


class CompanyTest extends PhalconTestCase
{
    protected $di;
    /**
     * @var bool
     */
    private $_loaded = false;

    public function testGetInitials()
    {
        $this->assertArrayHasKey(0, \Application\Backend\Entity\Company::getInitials());
    }

    public function setUp(Phalcon\DiInterface $di = NULL, Phalcon\Config $config = NULL)
    {
        // Load any additional services that might be required during testing
        $this->di = DI::getDefault();

        // get any DI components here. If you have a config, be sure to pass it to the parent
        parent::setUp($this->di);

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