<?php

class Admin_Content_PagesController extends Zend_Controller_Action
{
	public function init()
    {
        /* Initialize action controller here */
        
        $this->view->charset = 'ISO-8859-1';

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

        $pages = new Admin_Model_Content_Page();
        $rows = $pages->fetchAll();

        $page = $this->_getParam('page', 1);
        $paginator = Zend_Paginator::factory($rows);
        // Seta a quantidade de registros por página
        $paginator->setItemCountPerPage(10);
        // Seta a página atual
        $paginator->setCurrentPageNumber($page);
        
        $this->view->assign("rows", $paginator);
    }

    /**
     * Create a New Page Action
     */
    public function newAction()
    {
        // Add Title
        $this->view->headTitle()->prepend('New Pages');

        // Add Css
        $this->view->headLink()->appendStylesheet('/css/admin/summernote.css');

        // Add Js
        $this->view->HeadScript(Zend_View_Helper_HeadScript::FILE, '/js/admin/summernote.min.js');

        // Set Form and Options
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
                    //$form->setDescription('Error Save');
                    $form->populate($data);
                    
                    // Get values ​​to populate textarea using javascript in view
                    $post = $page->mergeValues($form->getValues());
                    $this->view->content = $post;
                } else {
                    $values = $form->getValues();
                    $values += array('created' => array('page_created' => Zend_Date::now()->toString('yyyy-MM-dd HH:mm:ss') ));
                    // var_dump($page->mergeValues($values));                    
                    $page->insert($page->mergeValues($values));
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
            $selectPage = $page->find($id)->current(); // or $page->fetchRow("id = $id");
            $parentUser = $selectPage->findParentRow('Admin_Model_User');

            $this->view->user    = $parentUser;
            $this->view->content = $selectPage;
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
                    // $form->setDescription('Error Save');
                    $form->populate($data);
                    
                    // Get values ​​to populate textarea using javascript in view
                    $post = $page->mergeValues($form->getValues());
                    $this->view->content = $post;
                } else {
                    $values = $form->getValues();
                    $values += array(
                        'identifier' => array('changed_by'  => Zend_Auth::getInstance()->getIdentity()->user_id),
                        'update'     => array('page_update' => Zend_Date::now()->toString('yyyy-MM-dd HH:mm:ss')),                        
                    );

                    // var_dump($values);

                    $page->update($page->mergeValues( $values ), "id = $id" );
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
        $id   = $this->getRequest()->getParam('id');  
        if ($id > 0) {            
            $page->delete("id = $id");
            $this->_redirect('admin/content_pages');
        }  
    }
}