<?php

class Admin_Form_Content_Pages_Edit extends Admin_Form_Content_Pages_New
{
    public function init()
    {
        parent::init();
        $general = $this->general;
        $options = $this->options;
        $actions = $this->actions;
        // $hidden  = $this->hidden; 

        /* Reescrever os Botons para o novo Form Edit
         *
         */
        $general->removeElement('url_key');
        $general->addElement('text', 'url_key', array(
            'label'       => 'Url key:',
            'class'       => 'form-control',
            'placeholder' => 'Your Url key',
            'required' => true,
            'validators'  => array(
                array('Db_NoRecordExists', false, array(
                    'table'    => 'content_pages', 
                    'field'    => 'url_key',
                    'exclude'  => array('field' => 'id', 'value' => Zend_Controller_Front::getInstance()->getRequest()->getParam('id', null)),
                    'messages' => array('recordFound' => 'URL is key already exists')
                ))
            )
        ));
        $general->addDisplayGroup(array(
            'page_name',
            'url_key',
        ),'general', array('legend' => 'General'));
        $general->getDisplayGroup('general')->setDecorators(array(        
            'FormElements',
            'Fieldset',
            array('HtmlTag',array('tag'=>'div','class'=>'section'))
        ));

        /* Rewrite Buttons
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
            array('decorators' => array(
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
            'actions' => $actions,
            // 'hidden'  => $hidden
        ));
    }
}