<?php

class Application_Plugin_EndSession extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        // Inicia a Sessão
        Zend_Session::start();

       /* 15 minutos, por exemplo
        * 1 hora = 3600 segundos.
       */
        $tempoEmSegundos = 1800;

       /* Finalizar Sessão
        * Se o usuário logado ficou inativo por mais tempo que determinado, é deslogado e
        * redirecionado para o login.
       */
        if (isset($_SESSION['last_activity']) && ((time() - $_SESSION['last_activity']) > $tempoEmSegundos) && Zend_Auth::getInstance()->getIdentity() != null)
        {
          Zend_Auth::getInstance()->clearIdentity();
          $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
          $redirector->gotoSimpleAndExit('login', 'auth', 'admin');
        }
        
        // Seta a hora da última ação do usuário
        $_SESSION['last_activity'] = time();
    }
}