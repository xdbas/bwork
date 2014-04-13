<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Controller
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Action
 *
 * This is a class supposed to be extended by a controller to inherit its
 * methods and get access to the Http Request and Http Response
 *
 * @package Bwork
 * @subpackage Bwork_Controller
 * @version v 0.1
 * @abstract
 */
abstract class Bwork_Controller_Action
{

    /**
     * Holds the Router send to the invoker
     *
     * @var Bwork_Router_Router
     */
    protected $router;

    /**
     * Hold the Http Request object
     *
     * @var Bwork_Http_Request $request
     */
    protected $request;

    /**
     * Hold the http response Object
     *
     * @var Bwork_Http_Response $response
     */
    protected $response;

    /**
     * Hold the mock params set by a routing service
     *
     * @var array $mockParams ;
     */
    protected $mockParams;

    /**
     * Hold the layout enabled setting
     *
     * @var boolean $layoutEnabled
     */
    protected $layoutEnabled = true;


    /**
     * The construction method used to assign the Request and Response objects
     * to their variables
     *
     * @access public
     * @return Bwork_Controller_Action
     */
    public function __construct()
    {
        $this->setRequest(
            Bwork_Core_Registry::getInstance()->getResource('Bwork_Http_Request')
        );

        $this->setResponse(
            Bwork_Core_Registry::getInstance()->getResource('Bwork_Http_Response')
        );
    }

    /**
     * This will set the Request variable
     *
     * @param Bwork_Http_Request $request
     * @access public
     * @return Bwork_Controller_Action
     */
    public function setRequest(Bwork_Http_Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * This will return the request variable
     *
     * @access public
     * @return Bwork_Http_Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * This will set the Response variable
     *
     * @param Bwork_Http_Response $response
     * @access public
     * @return Bwork_Controller_Action
     */
    public function setResponse(Bwork_Http_Response $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * This will return the response variable
     *
     * @access public
     * @return Bwork_Http_Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * This will set the mockParams from the Router
     *
     * @param Bwork_Router_Router $router
     * @access protected
     * @return Bwork_Controller_Action
     */
    protected function setMockParams(Bwork_Router_Router $router)
    {
        $this->mockParams = $router->mockParams;

        return $this;
    }

    /**
     * The before filter gets called before the action
     * When the before filter returns a string or a layout
     * the action will not be invoked
     *
     * Even though this is not an abstract method it does not contain
     * any logic. This method should be overwritten in the subclass.
     *
     * @access public
     */
    public function beforeFilter()
    {
        return;
    }

    /**
     * @todo: Think about logic
     */
    public function afterFilter()
    {
        return;
    }

    /**
     * This will invoke an action
     *
     * @param Bwork_Router_Router $router
     * @access public
     * @final
     * @throws Bwork_Controller_Exception
     * @return void
     */
    final public function invoke(Bwork_Router_Router $router)
    {
        Bwork_Controller_Action::__construct();
        $this->router = $router;
        $this->setMockParams($router);

        $response = $this->beforeFilter();

        if ($response === null) {
            $action = $router->action . 'Action';
            $response = $this->$action($this->mockParams);
        }

        if ($response === null
            || is_string($response) === true
        ) {
            $this->handleString($response);
        } else {
            if ($response instanceof Bwork_View_View === true) {
                $this->handleView($response);
            } else {
                throw new Bwork_Controller_Exception('Return type from controllerAction should either be a string or an object');
            }
        }

        $this->afterFilter();
    }

    /**
     * This will handle a string return value retrieved from the action method
     *
     * @param null|string $content
     * @access protected
     * @return void
     */
    protected function handleString($content = null)
    {
        if ($this->layoutEnabled == true) {
            $layout = Bwork_Core_Registry::getInstance()->getResource('Bwork_Layout_Layout');
            $layout->setContent($content);

            $content = $layout->fetch();
        }

        $this->response->setBody($content);
    }

    /**
     * This will handle the return data retrieved from the action method
     *
     * @param Bwork_View_View $view
     * @throws Bwork_Controller_Exception
     * @access protected
     * @return void
     */
    protected function handleView(Bwork_View_View $view)
    {
        if ($view instanceof Bwork_View_View == false) {
            throw new Bwork_Controller_Exception('ControllerAction return value should be an instance of Bwork_View_View');
        }

        $content = $view->fetch();

        if ($this->layoutEnabled == true) {
            $layout = Bwork_Core_Registry::getInstance()->getResource('Bwork_Layout_Layout');

            $layout->mergeVariables($view->getVariables());
            $layout->setContent($content);

            $content = $layout->fetch();
        }

        $this->response->setBody($content);
    }

    /**
     * Called when invoking on an undefined method
     *
     * @param string $name
     * @param array $arguments
     * @throws Bwork_Controller_Exception
     * @return void
     */
    public function __call($name, array $arguments)
    {
        if (substr($name, -6) == 'Action') {
            $config = Bwork_Core_Registry::getInstance()->getResource('Bwork_Config_Confighandler');
            if ($config->get('dev_env') === true
                || $config->exists('404_page') === false
            ) {
                throw new Bwork_Controller_Exception(sprintf(
                    'Action %s does not exists and has been caught by __call',
                    $name
                ), 404);
            } else {
                $notfound_settings = $config->get('404_page');

                $this->router->controller = $notfound_settings['controller'];
                $this->router->action = $notfound_settings['action'];
                $this->router->module = $notfound_settings['module'];

                (new Bwork_Controller_Dispatcher())->dispatch($this->router);
                return;
            }
        }

        throw new Bwork_Controller_Exception(sprintf('Method %s does not exists and has been caught by __call', $name));
    }

}