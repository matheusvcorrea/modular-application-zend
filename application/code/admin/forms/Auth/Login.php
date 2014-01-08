<?php

class Admin_Form_Auth_Login extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');

        $this->setDecorators(array(
            //'FormErrors',
            'FormElements',
            array('HtmlTag', array('tag' => 'div', 'class' => 'form-wrapper')),
            array('Description', array('tag' => 'div', 'placement' => 'prepend', 'class' => 'alert alert-danger')),
            'Form'
        ));

        $this->setElementDecorators(array(
            'ViewHelper',
            array(
                array('data' => 'HtmlTag'),
                array('tag'  => 'div', 'class' => 'col-sm-12')
            ),
            array(
                array('openerror' => 'HtmlTag'),
                array('tag' => 'td', 'openOnly' => true, 'placement' => Zend_Form_Decorator_Abstract::APPEND)
            ),
            'Errors',
            array(
                array('closeerror' => 'HtmlTag'),
                array('tag' => 'td', 'closeOnly' => true, 'placement' => Zend_Form_Decorator_Abstract::APPEND)
            ),
            array('Description', array('tag' => 'div', 'class' => 'description')),
            array(
                'Label',
                array('tag' => 'div', 'class' => 'col-sm-12 control-label')
            ),
            array(
                array('row' => 'HtmlTag'),
                array('tag' => 'div', 'class' => 'form-group')
            ),
        ));

        $this->addElement('text', 'username', array(
            'label'       => 'Username:',
            'class'       => 'form-control',
            'placeholder' => 'Username',
            'required'    => true,
            'filters'     => array('StringTrim', 'StringToLower'),
            'validators' => array(
                'Alpha',
                array('StringLength', false, array(3, 20)),
            ),
        ));
 
        $this->addElement('password', 'password', array(
            'label'       => 'Password:',
            'class'       => 'form-control',
            'placeholder' => 'Password',
            'required'    => true,
        ));

        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label'  => 'Sing in',
            'class'  => 'btn btn-lg btn-primary btn-block',
            'decorators'=>array(
                'ViewHelper',
                array('HtmlTag', array('tag' => 'div','class' =>'form-group')),
            )
        ));
    }
}

