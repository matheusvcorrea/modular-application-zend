<?php
/**
 * Avid Library
 *
 * @category   Avid
 * @copyright  Copyright (c) 2011 Avid Online Enterprises Ltd. (http://avidonline.co.nz)
 */

class Avid_Config extends Zend_Config_Xml
{
    protected static $INSTANCE;
    /**
     * Implemented as a singleton pattern. Reads the local xml config.
     *
     * @throws Exception
     * @param null $options
     */
    public function __construct($options = null)
    {
        if(isset($INSTANCE))
            // throws an Exception
            throw new Exception("An instance of ".get_called_class()." already exists. It is a singleton.");
        $section = Avid::getEnvironment();
        $xml = APPLICATION_PATH.'/etc/config.xml';
        parent::__construct($xml, $section, $options);
    }

    /**
     * Returns the single (local) config instance for the application
     * @static
     * @return Avid_Config
     */
    public static function getInstance() {
        // ternary operator is that fast!
        if (!isset(self::$INSTANCE)) {
            $c = __CLASS__;
            self::$INSTANCE = new $c;
        }
        return self::$INSTANCE;
    }
    /**
     * Gets a config value from the config file
     *
     * Recurses through XML path, and replaces placeholders with correct value.
     *
     * @param $path
     * @return mixed
     */
    public function getData($path)
    {
        $nodes = explode('/', $path);
        $node = array_shift($nodes);
        $val = $this->$node;
        while(count($nodes)) {
            $node = array_shift($nodes);
            $val = $val->$node;
        }
        $val = preg_replace('#\{(.+?)\}#e', "\$this->getData('\\1')", $val);
        $val = str_replace('%BASE_DIR%', Avid::getBaseDir(), $val);
        return $val;
    }
}