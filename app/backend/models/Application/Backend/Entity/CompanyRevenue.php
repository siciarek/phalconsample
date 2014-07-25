<?php

namespace Application\Backend\Entity;

class CompanyRevenue extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->belongsTo('company_id', '\Application\Backend\Entity\Company', 'id', array(
            'alias' => 'company',
            'foreignKey' => true
        ));
    }
    
    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $company_id;

    /**
     *
     * @var integer
     */
    protected $workers_count;

    /**
     *
     * @var double
     */
    protected $revenue;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field company_id
     *
     * @param integer $company_id
     * @return $this
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;

        return $this;
    }

    /**
     * Method to set the value of field workers_count
     *
     * @param integer $workers_count
     * @return $this
     */
    public function setWorkersCount($workers_count)
    {
        $this->workers_count = $workers_count;

        return $this;
    }

    /**
     * Method to set the value of field revenue
     *
     * @param double $revenue
     * @return $this
     */
    public function setRevenue($revenue)
    {
        $this->revenue = $revenue;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field company_id
     *
     * @return integer
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * Returns the value of field workers_count
     *
     * @return integer
     */
    public function getWorkersCount()
    {
        return $this->workers_count;
    }

    /**
     * Returns the value of field revenue
     *
     * @return double
     */
    public function getRevenue()
    {
        return $this->revenue;
    }

    public function getSource()
    {
        return 'company_revenue';
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'company_id' => 'company_id', 
            'workers_count' => 'workers_count', 
            'revenue' => 'revenue'
        );
    }

}
