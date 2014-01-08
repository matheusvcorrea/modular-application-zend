<?php

class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{
	/*protected function _initLayout()
	{
	    $layout = Zend_Layout::getMvcInstance();
	    $layout->setLayout('admin');
	}*/

	protected function _initNavigation()
	{
		$tabConfig    = new Zend_Config_Xml(dirname(__FILE__) . '/configs/navigation.xml', 'tab');
		$tabContainer = new Zend_Navigation($tabConfig);
		Zend_Registry::set('tabs',$tabContainer);
	}
}