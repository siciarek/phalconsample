<?php
namespace Application\Backend\Entity;

use Application\Common\ORM\Behaviors\Sluggable;
use Application\Common\ORM\Behaviors\Timestampable;

class Company extends \Phalcon\Mvc\Model
{
    public static function getInitials() {

        $phql = "SELECT DISTINCT initial FROM Application\Backend\Entity\Company ORDER BY initial ASC";

        $result = \Phalcon\DI::getDefault()->get('modelsManager')->executeQuery($phql);
        $initials = [];
        foreach ($result as $row) {
            $initials[$row->initial] = mb_strtoupper($row->initial, 'UTF-8');
        }

        return $initials;
    }

    public function __toString() {
        return $this->getName()?:'';
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasOne('id', '\Application\Backend\Entity\CompanyRevenue', 'company_id', array(
            'alias' => 'revenue',
            'foreignKey' => true
        ));

        $this->addBehavior(new Sluggable());
        $this->addBehavior(new Timestampable());
    }

    public function getSource()
    {
        return 'company';
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'enabled' => 'enabled',
            'slug' => 'slug',
            'name' => 'name',
            'initial' => 'initial',
            'info' => 'info',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at'
        );
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
    protected $enabled;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $initial;

    /**
     *
     * @var string
     */
    protected $info;

    /**
     *
     * @var string
     */
    protected $created_at;

    /**
     *
     * @var string
     */
    protected $updated_at;

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
     * Method to set the value of field enabled
     *
     * @param integer $enabled
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field initial
     *
     * @param string $initial
     * @return $this
     */
    public function setInitial($initial)
    {
        $this->initial = $initial;

        return $this;
    }

    /**
     * Method to set the value of field info
     *
     * @param string $info
     * @return $this
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Method to set the value of field created_at
     *
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Method to set the value of field updated_at
     *
     * @param string $updated_at
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

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
     * Returns the value of field enabled
     *
     * @return integer
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field initial
     *
     * @return string
     */
    public function getInitial()
    {
        return $this->initial;
    }

    /**
     * Returns the value of field info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    public function getSluggableValues() {
        return array(
            $this->getName()
        );
    }

    /**
     * Returns the value of field created_at
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Returns the value of field updated_at
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

}
