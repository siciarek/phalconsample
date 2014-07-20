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

class UserRegistrationForm extends CommonForm
{
    public function initialize()
    {
        // First name

        $first_name = new Text('first_name', array(
            'maxlength' => 127,
            'required' => 'required',
        ));
        $first_name->setLabel($this->di->get('trans')->query('user.first_name'));
        $first_name
            ->addValidators(array(
                new PresenceOf(array(
                    'cancelOnFail' => true,
                    'message' => 'user.error.no_first_name'
                )),
                new StringLength(array(
                    'min' => 2,
                    'messageMinimum' => 'user.error.too_short_first_name',
                    'max' => 127,
                    'messageMaximum' => 'user.error.too_long_first_name',
                ))
            ))
            ->addFilter('trim')
            ->addFilter('striptags')
            ->addFilter('removeq')
            ->addFilter('saxgen')
            ->addFilter('title')
            ->addFilter('null')
        ;

        // Last name

        $last_name = new Text('last_name', array(
            'required' => 'required',
            'maxlength' => 127,
        ));
        $last_name->setLabel($this->di->get('trans')->query('user.last_name'));
        $last_name
            ->addValidators(array(
                new PresenceOf(array(
                    'cancelOnFail' => true,
                    'message' => 'user.error.no_first_name'
                )),
                new StringLength(array(
                    'min' => 2,
                    'messageMinimum' => 'user.error.too_short_last_name',
                    'max' => 127,
                    'messageMaximum' => 'user.error.too_long_last_name',
                ))
            ))
            ->addFilter('trim')
            ->addFilter('striptags')
            ->addFilter('removeq')
            ->addFilter('saxgen')
            ->addFilter('title')
            ->addFilter('null')
        ;

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

        // Confirm password

        $confirm_password = new Password('confirm_password', array(
            'maxlength' => 127,
            'required' => 'required',
        ));
        $confirm_password->setLabel($this->di->get('trans')->query('user.confirm_password'));
        $confirm_password
            ->addValidators(array(
                new Confirmation(array(
                    'with'   => 'password',
                    'message' => 'user.error.passwords_does_not_match',
                ))
            ));

        // Submit button

        $submit = new Submit('submit', array(
            'value' => $this->di->get('trans')->query('common.save')
        ));

        // Collect fields
        $this->add($first_name);
        $this->add($last_name);
        $this->add($email);
        $this->add($password);
        $this->add($confirm_password);
        $this->add($submit);

        parent::initialize();
    }
}