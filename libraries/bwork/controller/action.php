<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Controller
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 */

/**
 * Action
 *
 * This is a class supposed to be extended by a controller to get access to 
 * things like Http Request and Http Response
 *
 * @package Bwork
 * @subpackage Bwork_Controller
 * @version v 0.1
 * @abstract
 */
abstract class Bwork_Controller_Action {
    
    /**
     * Hold the Http Request object
     * @var Bwork_Http_Request $request
     */
    protected $request;
    
    /**
     * Hold the http response Object
     * @var Bwork_Http_Response $response
     */
    protected $response;
    
    /**
     * Hold the mock params set by a routing service
     * @var array $mockParams;
     */
    protected $mockParams;
    
    /**
     * Hold the layout enabled setting
     * @var boolean $layoutEnabled
     */
    protected $layoutEnabled = true;


    /**
     * The construction method used to assign the Request and Response objects
     * to their variables
     * @access public
     * @return void
     */
    public function __construct() {
        $this->setRequest(
                Bwork_Core_Registry::getInstance()
                ->getResource("Bwork_Http_Request")
        ); 
        
        $this->setResponse(
                Bwork_Core_Registry::getInstance()
                ->getResource("Bwork_Http_Response"
        ));
    }
    
    /**
     * This will set the Request variable
     * @param Bwork_Http_Request $request
     * @access public
     * @return void 
     */
    public function setRequest(Bwork_Http_Request $request) {
        $this->request = $request;
    }
    
    /**
     * This will return the request variable
     * @access public
     * @return Bwork_Http_Request 
     */
    public function getRequest() {
        return $this->request;
    }
    
    /**
     * This will set the Response variable
     * @param Bwork_Http_Response $response 
     * @access public
     * @return void
     */
    public function setResponse(Bwork_Http_Response $response) {
        $this->response = $response;
    }
    
    /**
     * This will return the response variable
     * @access public
     * @return Bwork_Http_Response 
     */
    public function getResponse() {
        return $this->response;
    }
    
    /**
     * This will set the mockParams from the Router
     * @param Bwork_Router_Router $router 
     * @access public
     * @return void
     */
    public function setMockParams(Bwork_Router_Router $router) {
        $this->mockParams = $router->mockParams;
    }
    
    /**
     * This will invoke an action
     * @param Bwork_Router_Router $router 
     * @return void
     * @access public
     */
    public function invoke(Bwork_Router_Router $router) {
        Bwork_Controller_Action::__construct();
        $this->setMockParams($router);
        
        $action = $router->action.'Action';      
        if(in_array($action, get_class_methods($this)) == false) {
           $this->__call($action, array());
        }
        
        if(is_callable(array($this, $action)) == false) {
            throw new Bwork_Exception_ControllerException(sprintf("Unable to call action %s", $action));
        }
        
        $methodReflection = new ReflectionMethod($this, $action);
        $returnData = $methodReflection->invoke($this, isset($this->mockParams)? $this->mockParams : null);
        
        if(is_string($returnData) 
        || is_null($returnData)) {
            $this->handleString($returnData);
        }
        else if(is_object($returnData)) {
           $this->handleView($returnData); 
        }
        else {
            throw new Bwork_Exception_ControllerException("Return type from controllerAction should either be a string or an object");
        }
    }
    
    /**
     * This will handle a string return value retrieved from the action method
     * @param string $content 
     * @access public
     * @return void
     */
    public function handleString($content = null) {
        $this->response->setBody($content);
    }
    
    /**
     * This will handle the return data retrieved from the action method
     * @param mixed $data 
     * @access public
     * @return void
     */
    public function handleView(Bwork_View_IView $view) {

        if($view instanceof Bwork_View_IView == false) {
            throw new Bwork_Exception_ControllerException("ControllerAction return value should be an instance of Bwork_View_IView");
        }
        
        $content = $view->fetch();

        if($this->layoutEnabled == true) {
            $layout = Bwork_Core_Registry::getInstance()->getResource("Bwork_Layout_ILayout");
            
            $layout->mergeVariables($view->getVariables());
            $layout->setContent($content);
            
            $content = $layout->fetch();
        }
        
        $this->response->setBody($content);
    }
    
    /**
     * Called when invoking on an undifined method
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public function __call($name, $arguments) {
        if(substr($name, -6) == "Action") {
            throw new Bwork_Exception_ControllerException(sprintf("Action %s does not exists and has been cought by __call", $name));
        }
                
        throw new Bwork_Exception_ControllerException(sprintf("Method %s does not exists and has been cought by __call", $name));
    }
    
}