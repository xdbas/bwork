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
 * Router
 *
 * This class will attempt te resolve the right controller and action used for 
 * dispatching. It is possible to add handlers that will check a route each on 
 * its own way
 *
 * @package Bwork
 * @subpackage Bwork_Router
 * @version v 0.2
 */
class Bwork_Router_Router
{
    
    /**
     * Holds all the routing handler
     *
     * @access protected
     * @var array
     */
    protected $handlers = array();
    
    /**
     * Will hold the controller value
     *
     * @access public
     * @var string 
     */
    public $controller;
    /**
     * Will hold the action value
     *
     * @access public
     * @var string 
     */
    public $action;
    
    /**
     * Will hold specific mock parameters gained from a route
     *
     * @access public
     * @var array
     */
    public $mockParams;
    
    /**
     * Will hold the module name which is resolved
     *
     * @access public
     * @var String
     */
    public $module = null;

    /**
     * Will hold the URI Params gained from Bwork_Http_Request object
     *
     * @access protected
     * @var array 
     */
    protected $uriParams;
    /**
     * Will hold the current URI gained from Bwork_Http_Request object
     *
     * @access protected
     * @var string 
     */
    protected $requestUri;

    /**
     * This function will initialize the routing object and resolve the current URI values
     *
     * @param Bwork_Http_Request $requestObject
     * @access public
     * @return Bwork_Router_Router
     */
    public function __construct(Bwork_Http_Request $requestObject)
    {
        $this->uriParams = $requestObject->countParams() > 0? $requestObject->getParams() : array();
        $this->requestUri = $requestObject->__toString();
    }

    /**
     * Will attempt to add an inputted handler to the handlers property
     *
     * @param Bwork_Router_Handler $handler
     * @access public
     * @throws Bwork_Router_Exception
     * @return Bwork_Router_Router
     */
    public function setHandler(Bwork_Router_Handler $handler)
    {
        if($handler instanceof Bwork_Router_Handler == false) {
            throw new Bwork_Router_Exception(sprintf('%s should be and instance of Bwork_Router_Handler_Interface', get_class($handler)));
        }
        
        $this->handlers[get_class($handler)] = $handler;
        
        return $this;
    }
    
    /**
     * This is the main function which will handle the full routing process
     *
     * @access public
     * @return void
     */
    public function route()
    {
        $routed = false;

        if(count($this->handlers) > 0) {
            foreach($this->handlers as $handler) {
                if($handler->checkRoute($this->uriParams) === true) {
                    $route = $handler->getParams();
                    
                    $this->controller   = $route->controller;
                    $this->action       = $route->action;
                    $this->module       = $route->module;
                    $this->mockParams   = $route->mockParams;

                    $routed = true;
                    break;
                }
            }
        }
        
        if($routed === false) {
            $this->checkDefaultSegments();
        }
    }

    /**
     * If there is no specific Route found for the current URI this will attempt to resolve the controller and action in the default way
     *
     * @access private
     * @throws Bwork_Router_Exception
     * @return void
     */
    private function checkDefaultSegments()
    {
        if(count($this->uriParams) == 0) {
            $this->setDefault();
            return;
        }
        
        $this->controller = $this->uriParams[0];
        
        if(isset($this->uriParams[1])) {
           $this->action = $this->uriParams[1];
        }
        else {
            $config = Bwork_Core_Registry::getInstance()->getResource('Bwork_Config_Confighandler');
            if($config->exists('default_action') == false) {
                throw new Bwork_Router_Exception('There was no default_action property set in Bwork_Config_Confighandler');
            }
            $this->action = $config->get('default_action');
        }
        
        $this->mockParams = array();
    }

    /**
     * This will attempt to set the default controller an action values as set in a Config file
     *
     * @access public
     * @access public
     * @throws Bwork_Router_Exception
     * @return void
     */
    public function setDefault()
    {
        $config = Bwork_Core_Registry::getInstance()->getResource('Bwork_Config_Confighandler');
        
        if($config->exists('default_controller') == false) {
            throw new Bwork_Router_Exception('There was no default_controller property set in Bwork_Config_Confighandler');
        }
        $this->controller = $config->get('default_controller');
        
        if($config->exists('default_action') == false) {
            throw new Bwork_Router_Exception('There was no default_action property set in Bwork_Config_Confighandler');
        }
        $this->action = $config->get('default_action');
        
        $this->mockParams = array();
    }
    
}