<?php

class Admin_Form_Content_Pages_New extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'div', 'class' => 'form-wrapper tab-content')),
            array('Description', array('tag' => 'div', 'placement' => 'prepend', 'class' => 'alert alert-danger')),
            'Form'
        ));
        
        /*
         *
         */
        $general = new Zend_Form_SubForm;
        $general->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'div', 'class' => 'tab-pane active', 'id' => 'general')),
            'Form'
        ));
        $general->setElementDecorators(array(
            'ViewHelper', array(
                array('data' => 'HtmlTag'),
                array('tag'  => 'div', 'class' => 'col-xs-6')
            ),
            'Errors',
            array(
                'Label',
                array('tag' => 'div', 'class' => 'col-sm-2 control-label')
            ),
            array(
                array('row' => 'HtmlTag'),
                array('tag' => 'div', 'class' => 'form-group')
            ),
        ));        
        $general->addElement('text', 'page_name', array(
            'label'       => 'Name:',
            'class'       => 'form-control',
            'placeholder' => 'Name of the new Page',
            'required'    => true
        ));
        $general->addElement('text', 'page_url', array(
            'label'       => 'Url key:',
            'class'       => 'form-control',
            'placeholder' => 'Your Url key',
            'required'    => true,
        ));
        $general->addDisplayGroup(array(
            'page_name',
            'page_url',
        ),'general', array('legend' => 'General'));
        $general->getDisplayGroup('general')->setDecorators(array(        
            'FormElements',
            'Fieldset',
            array('HtmlTag',array('tag'=>'div','class'=>'section'))
        ));
        $general->addElement('text', 'page_header', array(
            'label'       => 'Header:',
            'class'       => 'form-control',
            'placeholder' => 'Your Content Header',
            'required'    => true,
        ));
        $general->addElement('textarea', 'page_content', array(
            'label'       => 'Content:',
            'class'       => 'form-control summernote',
            'placeholder' => 'Content',
            'required'    => true,
            'decorators' => array(
                array('ViewHelper'),
                array('Errors'),
                array(
                    'data'  =>'HtmlTag',
                    array('class'   => 'col-xs-9')
                ),
                array(
                    'Label',
                    array('tag' => 'div', 'class' => 'col-sm-2 control-label')
                ),
                array(
                    array('row' => 'HtmlTag'),
                    array('tag' => 'div', 'class' => 'form-group')
                )
            ),
        ));
        $general->addDisplayGroup(array(
            'page_header',
            'page_content'
        ),'body', array('legend' => 'Content Information'));
        $general->getDisplayGroup('body')->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag',array('tag'=>'div','class'=>'section'))
        ));

        /*
         *
         */
        $options = new Zend_Form_SubForm;
        $options->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'div', 'class' => 'tab-pane', 'id' => 'options')),
        ));
        $options->addElement('select','page_status', array(
            'label' => 'Status:',
            'value' => 'desable',
            'multiOptions' => array(
                'enable'  => 'Enable',
                'desable' => 'Desable'
                ),
            'class' => 'form-control',
        ));
        $options->addDisplayGroup(array(
            'page_status'
        ),'options', array('legend' => 'Options Information'));
        $options->getDisplayGroup('options')->setDecorators(array(        
            'FormElements',
            'Fieldset',
            array('HtmlTag',array('tag'=>'div','class'=>'section'))
        ));        
        $options->setElementDecorators(array(
            'ViewHelper', array(
                array('data' => 'HtmlTag'),
                array('tag'  => 'div', 'class' => 'col-xs-6')
            ),
            array(
                'Label',
                array('tag' => 'div', 'class' => 'col-sm-2 control-label')
            ),
            array(
                array('row' => 'HtmlTag'),
                array('tag' => 'div', 'class' => 'form-group')
            )
        ));

        /*
         *
         */
        $actions = new Zend_Form_SubForm();
        $actions->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'div','class'=>'actions-group')),
        ));

        /*
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
            'class'  => 'btn btn-danger',
        ));
        $buttons->addDisplayGroup(
            array(
                'save',
                'cancel'
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