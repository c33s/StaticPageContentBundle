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
        
        $options['match_request_variables']['name'] = $this->staticPageName;
        
        parent::__construct($routeName, $options, $menu);
    }
    
    /**
     * Add variable values defined in $addRequestVariables to the given
     * urlParameters. This can be used to pass through generally available
     * request parameters.
     *
     * @param array $urlParameters
     *
     * @return array
     */
    protected function addRequestVariablesToUrlParameters(array $urlParameters)
    {
        $urlParameters = parent::addRequestVariablesToUrlParameters($urlParameters);
        $urlParameters['name'] = $this->staticPageName;
                
        return $urlParameters;
    }
    
    /**
     * Add a child to the menu using item data.
     *
     * Possible value for position are:
     * * 'last': insert at last position (append), this is the default
     * * 'first': insert at first position
     * * positive number (e.g. 2): insert at this position, count starts at 0
     * * negative number (e.g. -1): insert at this position from the END of the children backwards
     *
     * @param string $routeName
     * @param array $options
     * @param string $position
     *
     * @return MenuItem    The generated item
     */
    public function addChildByData($routeName, $options, $position = 'last')
    {
        if (substr($routeName, 0, 2) == './')
        {
            $routeName = $this->routeName.'/'.$this->staticPageName.substr($routeName, 1);
        }
        
        return parent::addChildByData($routeName, $options, $position);
    }
}
