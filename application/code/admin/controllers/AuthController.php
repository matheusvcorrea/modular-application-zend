<?php

class Admin_AuthController extends Zend_Controller_Action
{
    public function init()
    {
        // Initialize action controller here
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->layout->setLayout('login');
    }

    /**
     * Index Action
     */
    public function indexAction()
    {
        if(!Zend_Auth::getInstance()->hasIdentity())
        {
            $this->_redirect('admin/auth/login');
        } else {
            $this->_redirect('admin/dashboard');
        }
    }

    /**
     * Login Action
     */
    public function loginAction()
    {
        // Set Fomr
        $form = new Admin_Form_Auth_Login();
        $this->view->form = $form;

        if($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost();            
            if ($form->isValid($data))
            {
                $dbAdapter   = Zend_Db_Table::getDefaultAdapter();
                $authAdapter = new Zend_Auth_Adapter_DbTable(
                    $dbAdapter,
                    'users',
                    'username',
                    'password',
                    'MD5(CONCAT(?, password_salt))'
                );

                $authAdapter->setIdentity($form->getValue('username'));
                $authAdapter->setCredential($form->getValue('password'));                
                
                // Efetua o login
                $auth   = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                
                if ($result->isValid())
                {
                    // Armazena os dados do usuário em sessão, apenas desconsiderando a senha do usuário
                    $info    = $authAdapter->getResultRowObject(null, 'password');
                    $storage = $auth->getStorage();
                    $storage->write($info);

                    // Redireciona para o Controller protegido
                    return $this->_helper->redirector->goToRoute(array(
                        'controller' => 'dashboard',
                        'module'     => 'admin'
                        ), null, true);
                } else {               
                    $form->setDescription('Username or password do not exist');
                    //$form->addError('Username or password do not exist');
                }
            } else {
                $form->populate($data);
            }
        }
    }

    /**
     * Logout Action
     */
    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        return $this->_helper->redirector('index');
    }
}