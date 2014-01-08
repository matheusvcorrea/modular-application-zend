<?php
/**
 * Avid Library
 *
 * @category   Avid
 * @copyright  Copyright (c) 2011 Avid Online Enterprises Ltd. (http://avidonline.co.nz)
 */

/**
 * Block class for use when rendering with a phtml template
 */
class Avid_Block_Template extends Avid_Block_Abstract
{
    /**
     * Renders the block using the attached template
     * @return string
     */
    protected function _toHtml()
    {
        $this->addScriptPath(Avid::getBaseDir('templates'));
        return $this->render($this->getTemplate());
    }
}