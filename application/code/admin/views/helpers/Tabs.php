<?php

Class Admin_View_Helper_Tabs extends Zend_View_Helper_Navigation_Menu
{
    /**
     *
     */
    public function tabs(Zend_Navigation_Container $container = null)
    {
        if (null !== $container)
        {
            $this->setContainer($container);
        }
        return $this; 
    }

    /**
     *
     */
    public function render(Zend_Navigation_Container $container = null)
    {
        if (null === $container)
        {
            $container = $this->getContainer();
        }

        $html = '<ul class="nav nav-tabs" id="myTabs">';
        foreach ($container as $page)
        {
            $html .= '<li '.(empty($page->active) ? '' : 'class="active"').'>';
            $html .= '<a href="'.(empty($page->uri) ? '#' : '#'.$page->uri ).'" data-toggle="tab">'.$page->label.'</a>';
            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }
}