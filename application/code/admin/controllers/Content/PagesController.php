<?php

class Admin_Content_PagesController extends Zend_Controller_Action
{
	public function init()
    {
        $this->view->charset = 'ISO-8859-1';
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
        // Add Title
        $this->view->headTitle()->prepend('List Pages');

        $page = new Admin_Model_Content_Page();
        $rows = $page->fetchAll();
        $this->view->assign("rows", $rows);
    }

    /**
     * Create a New Page Action
     */
    public function newAction()
    {
        // Add Title
        $this->view->headTitle()->prepend('New Pages');

        // Add Css
        $this->view->headLink()->appendStylesheet('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css');
        $this->view->headLink()->appendStylesheet('/css/admin/summernote.css');        

        // Add Js
        $this->view->HeadScript(Zend_View_Helper_HeadScript::FILE, '/js/admin/summernote.min.js');

        // Set Fomr and Options
        $form = new Admin_Form_Content_Pages_New();        
        $this->view->form = $form;

        $page = new Admin_Model_Content_Page();

        if($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost();
            if(!empty($data['actions']['buttons']['save']))
            {
                if (!$form->isValid($data))
                {
                    $form->setDescription('Error Save');
                    $form->populate($data);
                    
                    $post = $page->mergeValues($form->getValues());
                    $this->view->content = $post;
                } else {
                    //var_dump($page->mergeValues($form->getValues()));
                    $page->insert( $page->mergeValues($form->getValues()) );
                    //$form->populate($data);
                    $this->_redirect('admin/content_pages');
                }
            } else if(!empty($data['actions']['buttons']['cancel'])) {
                $this->_redirect('admin/content_pages');
            }
        }
    }

    /**
     * View Pages Action
     */
    public function viewAction()
    {
        $page = new Admin_Model_Content_Page();
        $id = $this->getRequest()->getParam('id');
        if ($id > 0)
        {            
            $result = $page->find($id)->current(); // or $page->fetchRow("id = $id");  
            $this->view->content = $result;
        }  
    }

    /**
     * Edit Pages Action
     */
    public function editAction()
    {
        // Add Title
        $this->view->headTitle()->prepend('Edit Page');

        // Add Css
        $this->view->headLink()->appendStylesheet('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css');
        $this->view->headLink()->appendStylesheet('/css/admin/summernote.css');        

        // Add Js
        $this->view->HeadScript(Zend_View_Helper_HeadScript::FILE, '/js/admin/summernote.min.js');

        $form = new Admin_Form_Content_Pages_Edit();
        $this->view->form = $form;
        
        $page = new Admin_Model_Content_Page();
        $id = $this->getRequest()->getParam('id');
                
        if($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost();
            if(!empty($data['actions']['buttons']['save']))
            {
                if (!$form->isValid($data))
                {
                    $form->setDescription('Error Save');
                    $form->populate($data);
                    
                    $post = $page->mergeValues($form->getValues());
                    $this->view->content = $post;
                } else {                    
                    $page->update($page->mergeValues($form->getValues()), "id = $id" );
                    $this->_redirect('admin/content_pages');
                }
            } else if(!empty($data['actions']['buttons']['cancel'])) {
                $this->_redirect('admin/content_pages');
            } else if(!empty($data['actions']['buttons']['delete'])) {                
                return $this->_helper->redirector->goToRoute(array(
                    'module'     => 'admin',
                    'controller' => 'content_pages',
                    'action'     => 'delete',
                    'id'         => $id
                    ), null, true);
            }
        } else {
            $post = $page->find($id)->current();  
            $form->populate($post->toArray()); // populate method parameter has to be an array
            $this->view->content = $post;
        }
    }

    /**
     * Delete Pages Action
     */
    public function deleteAction()
    {
        $page = new Admin_Model_Content_Page();
        $id = $this->getRequest()->getParam('id');  
        if ($id > 0) {            
            $page->delete("id = $id");
            $this->_redirect('admin/content_pages');
        }  
    }
}