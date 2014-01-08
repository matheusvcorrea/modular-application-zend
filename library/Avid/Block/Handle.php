<?php
/**
 * Avid Library
 *
 * @category   Avid
 * @copyright  Copyright (c) 2011 Avid Online Enterprises Ltd. (http://avidonline.co.nz)
 */

class Avid_Block_Handle extends Avid_Model_Abstract implements Countable, IteratorAggregate
{

    protected $_items;
    protected static $INSTANCES = array();

    /**
     * Construct the handle as a semi-singleton such that only one handle can exist for each handle name.
     *
     * @throws Exception
     * @param string $name
     * @param null $options
     */
    public function __construct($name, $options = null)
    {
        if(isset($INSTANCES[$name]))
            throw new Exception("An instance of ".get_called_class()." for the handle {$this->_name} already exists. It is a singleton.");
        $this->_name = $name;
        if ($this->_name != 'default') $this->_mergeHandle('default');
    }

    /**
     * Gets the handle instance for a particular handle name
     *
     * @static
     * @param string $name
     * @return Avid_Block_Handle
     */
    public static function getHandle($name)
    {

        if (!isset(self::$INSTANCES[$name])) {
            $c = __CLASS__;
            self::$INSTANCES[$name] = new $c($name);
        }
        return self::$INSTANCES[$name];
    }

    /**
     * Gets the blocks directly descended from the handle
     *
     * @todo: Inherit handle from block.
     * @return array
     */
    public function getBlocks()
    {
        return $this->_items;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getItems());
    }

    /**
     * Gets the number of blocks directly descended from the handle (root);
     *
     * @return int number of blocks
     */
    public function count()
    {
        return count($this->getItems());
    }

    /**
     * Gets a block inside the handle, will traverse child blocks
     *
     * @param $name
     * @return Avid_Block_Abstract
     */
    public function getBlock($name)
    {
        if (count($this->_items)) foreach ($this->_items as $item) {
            if ($item->getName() == $name) return $item;
        }
    }

    /**
     * Adds a block as a direct descendant of the handle.
     *
     * @param Avid_Block_Abstract $block
     * @return Avid_Block_Handle
     */
    public function addBlock(Avid_Block_Abstract $block)
    {
        $this->_items[] = $block;
        return $this;
    }

    /**
     * Merge another handle such that its children become children of this block.
     *
     * Will be used to merge the default handle.
     *
     * @param $handle
     * @return void
     */
    protected function _mergeHandle($handle)
    {
        if (is_string($handle)) $handle = Avid_Block_Handle::getHandle($handle);
        $blocks = $handle->getBlocks();
        if (count($blocks)) foreach ($blocks as $block) {
            $this->addBlock($block);
        }
    }
}