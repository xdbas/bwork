<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Router
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Route
 *
 * This class is used to store a route
 *
 * @package Bwork
 * @subpackage Bwork_Route
 * @version v 0.1
 */
class Bwork_Router_Route
{

    /**
     * This var holds the controller name for the route
     *
     * @var string $controller
     * @access public
     */
    public $controller;

    /**
     * This var holds the action name for the route
     *
     * @var string $action
     * @access public
     */
    public $action;

    /**
     * This var holds a initialized module name
     *
     * @var string $module
     * @access public
     */
    public $module;

    /**
     * This var holds possible mockParams which can be accessed from an action
     *
     * @var array $mockParams
     * @access public
     */
    public $mockParams;

    /**
     * This is the constructor method used to assign vars used in a route
     *
     * @param string $controller
     * @param string $action
     * @param string $module
     * @param array $mockParams
     * @access public
     * @return Bwork_Router_Route
     */
    public function __construct($controller, $action, $module = null, $mockParams = array())
    {
        $this->controller = $controller;
        $this->action     = $action;
        $this->module     = $module;
        $this->mockParams = $mockParams;
    }
}