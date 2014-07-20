<?php
namespace Application\Common\Form;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Hidden;

class CommonForm extends Form
{
    public function initialize()
    {
        $csrf = new Hidden('csrf');
        $csrf->setDefault($this->getCsrf());
        $this->add($csrf);
    }

    /**
     * This method returns the default value for field 'csrf'
     */
    public function getCsrf()
    {
        return $this->security->getToken();
    }
}