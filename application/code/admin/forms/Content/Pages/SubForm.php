<?php

class Admin_Form_Content_Pages_SubForm extends Zend_Form
{
    public function init()
    {
        // Create user sub form: username and password
        $user = new Zend_Form_SubForm();
        $user->addElements(array(
            new Zend_Form_Element_Text('username', array(
                'required'   => true,
                'label'      => 'Username:',
                'filters'    => array('StringTrim', 'StringToLower'),
                'validators' => array(
                    'Alnum',
                    array('Regex',
                          false,
                          array('/^[a-z][a-z0-9]{2,}$/'))
                )
            )),
 
            new Zend_Form_Element_Password('password', array(
                'required'   => true,
                'label'      => 'Password:',
                'filters'    => array('StringTrim'),
                'validators' => array(
                    'NotEmpty',
                    array('StringLength', false, array(6))
                )
            )),
        ));
 
        // Create demographics sub form: given name, family name, and
        // location
        $demog = new Zend_Form_SubForm();
        $demog->addElements(array(
            new Zend_Form_Element_Text('givenName', array(
                'required'   => true,
                'label'      => 'Given (First) Name:',
                'filters'    => array('StringTrim'),
                'validators' => array(
                    array('Regex',
                          false,
                          array('/^[a-z][a-z0-9., \'-]{2,}$/i'))
                )
            )),
 
            new Zend_Form_Element_Text('familyName', array(
                'required'   => true,
                'label'      => 'Family (Last) Name:',
                'filters'    => array('StringTrim'),
                'validators' => array(
                    array('Regex',
                          false,
                          array('/^[a-z][a-z0-9., \'-]{2,}$/i'))
                )
            )),
 
            new Zend_Form_Element_Text('location', array(
                'required'   => true,
                'label'      => 'Your Location:',
                'filters'    => array('StringTrim'),
                'validators' => array(
                    array('StringLength', false, array(2))
                )
            )),
        ));
 
        // Create mailing lists sub form
        $listOptions = array(
            'none'        => 'No lists, please',
            'fw-general'  => 'Zend Framework General List',
            'fw-mvc'      => 'Zend Framework MVC List',
            'fw-auth'     => 'Zend Framwork Authentication and ACL List',
            'fw-services' => 'Zend Framework Web Services List',
        );
        $lists = new Zend_Form_SubForm();
        $lists->addElements(array(
            new Zend_Form_Element_MultiCheckbox('subscriptions', array(
                'label'        =>
                    'Which lists would you like to subscribe to?',
                'multiOptions' => $listOptions,
                'required'     => true,
                'filters'      => array('StringTrim'),
                'validators'   => array(
                    array('InArray',
                          false,
                          array(array_keys($listOptions)))
                )
            )),
        ));

        $demog->setSubForms(array('lists' => $lists));
        $demog->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'div')),
        ));
 
        // Attach sub forms to main form
        $this->setSubForms(array(
            'user'  => $user,
            'demog' => $demog
        ));
    }
}