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
 * Application
 *
 * This class contains system startup function that will not need saving in 
 * the registry
 *
 * @package Bwork
 * @subpackage Bwork_Controller
 * @version v 0.3
 */
class Bwork_Application {
    
    /**
     * This function will require the autoloader class and initialize the object
     * 
     * @static
     * @access public
     * @return void
     */
    public static function _initAutoloader() {
        require_once LIBS."bwork/autoload.php";
        
        bwork_autoload::init();
    }
    
    /**
     * This will initialize the bootstrappers where the prebootstrapper is used 
     * for system processes and the normal bootstrapper is called from the 
     * application
     * @access public
     * @static
     * @return void
     */
    public static function _initBootstrap() {
        self::_initPreBootstrap();
        
        $bootstrap = new Bootstrap();
    }
    
    /**
     * @see Bwork_Application::_initBootstrap
     */
    public static function _initPreBootstrap() {
        $prebootstrap = new Bwork_Bootstrap_PreBootstrap();
    }
    
    /**
     * The main application function used to dispatch the project
     * 
     * @static
     * @access public
     * @return void
     */
    public static function Run() {
        $router = Bwork_Core_Registry::getInstance()->getResource("Bwork_Router_Router");
        $router->route();
        
        self::Dispatch($router);
    }
    
    /**
     * @see Bwork_Application::Run
     * @param Bwork_Router_Router $router
     */
    public static function Dispatch(Bwork_Router_Router $router) {
        $dispatcher = new Bwork_Controller_Dispatcher();
        $dispatcher->dispatch($router);
    }
    
}