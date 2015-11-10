<?php
namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\Factory;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct();

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
                'placeholder' => "Email",
            ),
            'options' => array(
                'label' => '',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'placeholder' => "Password",
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->initInputFilter();

    }

    public function initInputFilter() {
        $factory = new Factory();
        $inputFilter = $factory->createInputFilter(array(
            'email' => array(
                'name'     => 'email',
                'required' => true,
                'filter' => array('stringtrim', 'StripTags'),
                'validators' => array(
                    array(
                        'name' =>'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => 'The \'Email\' is required field.'
                            ),
                        ),
                    ),
                    array(
                        'name'    => 'StringLength',
                        'required' => true,
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'max'      => 15,
                            'messages' => array(
                                'stringLengthTooLong' => 'The \'First Name\' may contain maximum %max% characters.',
                            )
                        ),
                    ),
                ),

            ),
            'password' => array(
                'name'     => 'password',
                'required' => true,
                'filter' => array('stringtrim', 'StripTags'),
                'validators' => array(
                    array(
                        'name' =>'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => 'The \'Password\' is required field.'
                            ),
                        ),
                    ),
                ),
            ),
        ));
        $this->setInputFilter($inputFilter); ;
    }

}