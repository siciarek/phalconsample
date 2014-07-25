<?php

namespace Application\Backend\Entity;

class BrandNewModel extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    protected $data;

    /**
     *
     * @var integer
     */
    protected $modified_at;

    /**
     * Method to set the value of field data
     *
     * @param string $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Method to set the value of field modified_at
     *
     * @param integer $modified_at
     * @return $this
     */
    public function setModifiedAt($modified_at)
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    /**
     * Returns the value of field data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Returns the value of field modified_at
     *
     * @return integer
     */
    public function getModifiedAt()
    {
        return $this->modified_at;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('session');
    }

    public function getSource()
    {
        return 'session';
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'session_id' => 'session_id', 
            'data' => 'data', 
            'created_at' => 'created_at', 
            'modified_at' => 'modified_at'
        );
    }

}
