<?php
/**
 * Avid Library
 *
 * @category   Avid
 * @copyright  Copyright (c) 2011 Avid Online Enterprises Ltd. (http://avidonline.co.nz)
 */

abstract class Avid_Block_Abstract extends Zend_View implements Countable, IteratorAggregate
{
    protected $_items;
    protected $_data = array();
    protected static $INSTANCES = array();

    /**
     * Block semi-singleton constructor
     *
     * Implemented such that there can not be more than one block with the same name.
     *
     * @todo: allow same name in different handles? Only required if we need to load multiple base handl in one request
     * @throws Exception
     * @param string $name
     * @param array $options
     */
    public function __construct($name, $options = array())
    {
        $this->_name = $name;
        if(isset($INSTANCES[$this->_name]))
            throw new Exception("An instance of ".get_called_class()." for the block {$this->_name} already exists. It is a singleton.");
    }

    /**
     * Standard property setter
     *
     * Overrides the setter in Zend_View, which prohibits setting protected properties.
     *
     * @param string $key
     * @param string $val
     * @return
     */
    public function __set($key, $val)
    {
        $this->$key = $val;
        return;
    }

    /**
     * _toHtml
     *
     * The private method each class requires in order to output HTML
     *
     * @abstract
     * @return void
     */
    abstract protected function _toHtml();
    public function toHtml() {
        return $this->_toHtml();
    }

    /**
     * Returns the blocks directly descended from this block.
     *
     * @todo: Implement a block collection class.
     * @return array an array of blocks directly descended from this one.
     */
    public function getBlocks()
    {
        return $this->_items;
    }

    /**
     * Adds another block to this block's set of direct descendants
     *
     * @param Avid_Block_Abstract $item
     * @return Avid_Block_Abstract
     */
    public function addBlock(Avid_Block_Abstract $item)
    {
        $this->_items[] = $item;
        return $this;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getItems());
    }

    /**
     * Returns the number of direct descendants of this block.
     *
     * @return int
     */
    public function count()
    {
        return count($this->getItems());
    }

    /**
     * Gets a named block that is descended form this one. Will traverse all children.
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
     * Sets the attributes (properties) of the block, will usually be called by the layout generation
     *
     * @param array $attributes
     * @return Avid_Block_Abstract
     */
    public function setAttributes($attributes = array())
    {
        $this->setData($attributes);
        return $this;
    }

    /**
     * Adds a property to the block, via a setter, property or stored in the data array
     *
     * @param string $key
     * @param mixed $val
     * @return Avid_Block_Abstract
     */
    public function setData($key, $val = null)
    {
        if(is_array($key)) {
            foreach ($key as $k=>$v) $this->setData($k, $v);
            return $this;
        }
        $method = 'set'.Avid::toCamelCase($key, true);
        $property = '_'.Avid::toCamelCase($key, false);
        if (method_exists($this, $method)) $this->$method($val);
        if (property_exists($this, $property)) $this->$property = $val;
        else $this->_data[$key] = $val;
        return $this;
    }

    /**
     * Gets the path to the block's template
     *
     * @todo: implement a generic getter, and transsfer this method to the template subclass.
     * @return string
     */
    public function getTemplate()
    {
        return $this->_data['template'];
    }

    /**
     * Pulls information from the block's internal data array
     *
     * @param null $key
     * @return array|null
     */
    public function getData($key = null)
    {
        if ($key && isset($this->_data[$key])) {
            return $this->_data[$key];
        } elseif ($key) {
            return null;
        } else {
            return $this->_data;
        }
    }

    /**
     * Renders a single child block or all direct descendant blocks as HTML
     *
     * @param null $name
     * @return bool|string|void
     */
    public function getChildHtml($name = null)
    {
        if ($name) {
            if ($block = $this->getBlock($name)) return $block->toHtml();
            else return false;
        } else {
            $html = '';
            if (count($this->_items)) foreach ($this->_items as $item) {
                $html .= $item->toHtml();
            }
            return $html;
        }
    }
}