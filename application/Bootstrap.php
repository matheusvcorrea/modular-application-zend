<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initPlaceholders()
    {
    	$view = new Zend_View();
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view   = $layout->getView();
		
		// Doctype
		$view->doctype('HTML5');
		$view->setEncoding('UTF-8');
		
		// Tag Tittle
		$view->headTitle('Extremely Modular');
		$view->headTitle()->setSeparator(' / ');

		// Favicon
		$view->headLink(array(
	        'rel'  => 'favicon',
	        'type' => 'image/ico',
	        'href' => $view->baseUrl('favicon.ico')
	    ));
		
		// Add Stylesheets
		$view->headLink()->setStylesheet('/css/bootstrap.min.css');

		// Add Scripts
		$view->headScript()->prependFile('//code.jquery.com/jquery-1.10.2.min.js');
		$view->headScript()->appendFile('/js/bootstrap.min.js');
		$view->headScript()->appendFile('/js/modernizr.min.js');
		// $view->headScript()->appendFile('//localhost:35729/livereload.js');

		$uri = explode('/', $_SERVER['REQUEST_URI']);
	    if(in_array('admin', $uri)) {
	    	$layoutFile = 'admin';
		} else {
			$layoutFile = 'layout';
		}

		// Add Layouts
	    Zend_Layout::startMvc(array(
			'layout'     => $layoutFile,
			'layoutPath' => APPLICATION_PATH . '/layouts/scripts/',
		));
    }

	protected function _initNavigation()
	{
		// Init Anonymous Menu
		$navConfig    = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
		$navContainer = new Zend_Navigation($navConfig);
		Zend_Registry::set('main',$navContainer);

		/* Dynamic Manu - Menu From Database
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
    	$dbAdapter->setFetchMode(Zend_Db::FETCH_ASSOC);
    	$menuArray = $dbAdapter->fetchAll("SELECT * FROM menu");
		$navContainer = new Zend_Navigation();
	    foreach ( $menuArray as $item )
	    {
	        $navContainer->addPage(
	            Zend_Navigation_Page::factory(array(
	                'uri' => 'url',
	                'label' => 'Label',
	                'title' => 'title',
	                'class' => 'class',
	            ))
	        );
	    }
	    Zend_Registry::set('main', $navContainer);
	    */

		// Init Admin Menu
		$adminConfig    = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'admin');
		$adminContainer = new Zend_Navigation($adminConfig);
		Zend_Registry::set('admin',$adminContainer);
	}

	protected function _initRoutes()
	{
		$frontController = Zend_Controller_Front::getInstance();
		$router = $frontController->getRouter();

		$router->addRoute('login', new Zend_Controller_Router_Route(
			'login', array(
				'module'     => 'admin',
				'controller' => 'auth',
				'action'     => 'index',
			)
		));

		$router->addRoute('page', new Zend_Controller_Router_Route(
			':url_key/', array(
				'module'     => 'content',
				'controller' => 'page',
				'action'     => 'view'
			)
		));
    }
    
	protected function _initPlugins()
	{
		// Init Plugins
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(new Application_Plugin_EndSession());
	}	

    public static function getVersionInfo()
    {
        return array(
            'major'     => '0',
            'minor'     => '1',
            'revision'  => '0',
            'patch'     => '0',
            'stability' => '',
            'number'    => '',
        );
    }
}

