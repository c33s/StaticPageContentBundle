<?php

namespace c33s\StaticPageContentBundle\Menu;

use c33s\MenuBundle\Exception\OptionRequiredException;
use c33s\MenuBundle\Item\MenuItem;
use c33s\MenuBundle\Menu\Menu;

/**
 * Description of SimpleContentMenuItem
 *
 * @author david
 */
class StaticPageContentMenuItem extends MenuItem
{
    protected $staticPageName;
    
    /**
     * Construct a new menu item. It requires its routeName, options and
     * the menu the item is assigned to.
     *
     * SimpleContentMenuItem requires the following routeName notation:
     * routeName/pageName
     *
     * @see MenuItem::__construct()
     *
     * @throws OptionRequiredException
     *
     * @param string $routeName
     * @param array $options
     * @param Menu $menu
     */
    public function __construct($routeName, array $options, Menu $menu)
    {
        if (false === strpos($routeName, '/'))
        {
            throw new OptionRequiredException('StaticPageContentMenuItem requires routeName/pageName notation');
        }
        
        list($routeName, $this->staticPageName) = explode('/', $routeName, 2);
        
        parent::__construct($routeName, $options, $menu);
    }
    
    /**
     * Check if the item is currently selected itself. This is the case when
     * the current (request) route name matches the item route name or the
     * item's alias routes.
     *
     * @return boolean
     */
    public function isCurrentEndPoint()
    {
        return parent::isCurrentEndPoint() && $this->getRequest()->get('name') == $this->staticPageName;
    }
    
    /**
     * Generate a URL using the routing.
     *
     * @param array $urlParameters
     *
     * @return string
     */
    protected function generateStandardUrl(array $urlParameters = array(), $absolute = false)
    {
        $urlParameters['name'] = $this->staticPageName;
        
        return parent::generateStandardUrl($urlParameters, $absolute);
    }
}
