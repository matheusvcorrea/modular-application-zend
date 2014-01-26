<?php

class Content_PageController extends Zend_Controller_Action
{

    public function init()
    {
        $this->page = new Admin_Model_Content_Page();
    }

    public function indexAction()
    {
        // action body        
    }

    /**
     * View Pages Action
     */
    public function viewAction()
    {
        $page = $this->page;
        $url_key = $this->getRequest()->getParam('url_key');
        if (!empty($url_key))
        {
            $select  = $page->select()->where('url_key = ?', $url_key);
            $getPage = $page->fetchRow($select);
            
            if($getPage == null || $getPage->page_status == 'desable')
            {
                throw new Zend_Controller_Action_Exception('Not Found', 404);
            } else {
                $this->view->headTitle()->prepend($getPage->page_name);
                $this->view->content = $getPage;
            }
        } else {
            throw new Zend_Controller_Action_Exception('Not Found', 404);
        }
    }
}

