<?php

class Admin_Form_Content_Pages_Edit extends Admin_Form_Content_Pages_New
{
    public function init()
    {
        parent::init();
        $general = $this->general;
        $options = $this->options;
        $actions = $this->actions;

        /* Exemple to Add new Element
        $general->addElement('text', 'page_name_name', array(
            'label'       => 'Name:',
            'class'       => 'form-control',
            'placeholder' => 'Name of the new Page',
            'required'    => true
        ));

        $general->addDisplayGroup(array(
            'page_name',
            'page_url',
            'page_name_name'
        ),'general', array('legend' => 'General'));
        */

        /* Reescrever os Botons para o novo Form Edit
         *
         */
        $buttons = new Zend_Form_SubForm();
        $buttons->addElement('submit', 'save', array(
            'ignore' => true,
            'label'  => 'Save the Page',
            'class'  => 'btn btn-success',
        ));
        $buttons->addElement('submit', 'cancel', array(
            'ignore' => true,
            'label'  => 'Cancel',
            'class'  => 'btn btn-default',
        ));
        $buttons->addElement('submit', 'delete', array(
            'ignore' => true,
            'label'  => 'Delete',
            'class'  => 'btn btn-danger',
        ));
        $buttons->addDisplayGroup(
            array(
                'save',
                'cancel',
                'delete'
            ),'buttons',
            array('decorators'=>array(
                'FormElements',
                array('HtmlTag', array('tag'=>'div','class'=>'buttons')), 
                'DtDdWrapper',                   
            ))
        );
        $buttons->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag'=>'div','class'=>'buttons-group')),
        ));
        $buttons->getDisplayGroup('buttons')->setDecorators(array(        
            'FormElements',
            'Fieldset',
            array('HtmlTag',array('tag'=>'div','class'=>'buttons-elements'))
        ));        
        $buttons->setElementDecorators(array(
            'ViewHelper', array(
                array('data' => 'HtmlTag'),
                array('tag'  => 'div', 'class' => 'col-xs-6')
            ),
            array(
                array('row' => 'HtmlTag'),
                array('tag' => 'div', 'class' => 'form-group')
            )
        ));
        $actions->setSubForms(array('buttons'=>$buttons));

        // Attach sub forms to main form
        $this->setSubForms(array(
            'general' => $general,
            'options' => $options,
            'actions' => $actions
        ));
    }
}