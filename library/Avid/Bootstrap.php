<?php
/**
 * Avid Library
 *
 * @category   Avid
 * @copyright  Copyright (c) 2011 Avid Online Enterprises Ltd. (http://avidonline.co.nz)
 */

require_once('Avid/Core.php');
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Avid_');
class Avid_Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Initialise Module Autoloaders.
     *
     * Automatically registers the namespaces for the modules in the modules folder of the application, and adds the
     * block resource type to the resource autoloader.
     *
     * @return void
     */
    protected function _initModuleAutoloaders()
    {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');

        foreach ($front->getControllerDirectory() as $module => $directory) {
            $module = ucfirst($module);
            $loader = new Zend_Application_Module_Autoloader(array(
                'namespace' => $module,
                'basePath'  => dirname($directory),
            ));
            $loader->addResourceType('block', 'blocks', 'Block');
        }
    }

    /**
     * Initialise the layout using the Magento-style layout class.
     * @return void
     */
    protected function _initLayout()
    {
        Avid_Layout::startMvc();
    }

    protected function _initConfig()
    {
        $config = new Zend_Config($this->getOptions(), true);
        Zend_Registry::set('config', $config);
        return $config;
    }
}