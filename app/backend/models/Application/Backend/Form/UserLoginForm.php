<?php
namespace Application\Backend\Form;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Textarea;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Numeric;
use Phalcon\Forms\Element\Submit;

use Phalcon\Validation\Validator\PresenceOf;   // Validates that a field’s value is not null or empty string.
use Phalcon\Validation\Validator\Identical;    // Validates that a field’s value is the same as a specified value
use Phalcon\Validation\Validator\Email;        // Validates that field contains a valid email format
use Phalcon\Validation\Validator\ExclusionIn;  // Validates that a value is not within a list of possible values
use Phalcon\Validation\Validator\InclusionIn;  // Validates that a value is within a list of possible values
use Phalcon\Validation\Validator\Regex;        // Validates that the value of a field matches a regular expression
use Phalcon\Validation\Validator\StringLength; // Validates the length of a string
use Phalcon\Validation\Validator\Between;      // Validates that a value is between two values
use Phalcon\Validation\Validator\Confirmation; // Validates that a value is the same as another present in the data

use Application\Common\Form\CommonForm;

class UserLoginForm extends CommonForm
{
    public function initialize()
    {
       // $this->setEntity($this);

        // Email

        $email = new Text('email', array(
            'maxlength' => 127,
            'required' => 'required',
        ));
        $email->setLabel($this->di->get('trans')->query('user.email'));
        $email
            ->addValidators(array(
                new PresenceOf(array(
                    'cancelOnFail' => true,
                    'message' => 'user.error.no_email',
                )),
                new Email(array(
                    'message' => 'user.error.invalid_email',
                )),
                new StringLength(array(
                    'max' => 127,
                    'messageMaximum' => 'user.error.too_long_email',
                ))
            ))
            ->addFilter('trim')
            ->addFilter('striptags')
            ->addFilter('lower')
            ->addFilter('email');

        // Password

        $password = new Password('password', array(
            'maxlength' => 127,
            'required' => 'required',
        ));
        $password->setLabel($this->di->get('trans')->query('user.password'));
        $password
            ->addValidators(array(
                new PresenceOf(array(
                    'cancelOnFail' => true,
                    'message' => 'user.error.no_password'
                )),
                new Regex(array(
                    'pattern' => "/^(?=.*[a-ząćęłńóśźż])(?=.*[A-ZĄĆĘŁŃÓŚŹŻ])(?=.*[0-9])\S{8,32}/u",
                    'message' => 'user.error.invalid_password'
                )),
            ))
            ->addFilter('trim');

        // Submit button

        $submit = new Submit('submit', array(
            'value' => $this->di->get('trans')->query('user.log_in')
        ));

        // Collect fields
        $this->add($email);
        $this->add($password);
        $this->add($submit);

        parent::initialize();
    }
}