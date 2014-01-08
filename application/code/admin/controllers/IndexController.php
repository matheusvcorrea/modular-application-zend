<?php

class Admin_IndexController extends Zend_Controller_Action
{
	public function init()
    {
    	/* Initialize action controller here */        
        if(!Zend_Auth::getInstance()->hasIdentity())
        {
            $this->_redirect('admin/auth/login');
        }
	}

	/**
     * Index Action
     */
	public function indexAction()
	{
		
	}
}