<?php
namespace Application\Backend\Model;

class Person extends \Phalcon\Mvc\Model {

    /**
     * @var string $first_name
     */
    public $first_name;
    /**
     * @var string $last_name
     */
    public $last_name;

    public function __toString() {
        return $this->getFullName()?:'';
    }

    public function getFullName() {
        $fname = $this->firstName;
        $lname = $this->lastName;

        $temp = array_filter(array($fname, $lname), function($e) { $el = trim($e); return !empty($e);});

        $fullname = implode(' ', $temp);
        $fullname = trim($fullname)?:null;

        return $fullname;
    }
}
