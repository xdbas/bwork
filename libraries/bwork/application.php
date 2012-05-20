<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Application
 *
 * This class contains system startup function that will not need saving in 
 * the registry
 *
 * @package Bwork
 * @subpackage Bwork
 * @version v 0.4
 */
class Bwork_Application 
{
    
    /**
     * This function will require the autoloader class and initialize the object
     * 
     * @static
     * @access public
     * @return void
     */
    public static function _initAutoloader() 
    {
        require_once 'bwork/loader/libraryautoloader.php';
        spl_autoload_register(array(
            'Bwork_Loader_LibraryAutoloader', 'autoload'
        ));

        require_once 'bwork/loader/applicationautoloader.php';
        spl_autoload_register(array(
            'Bwork_Loader_ApplicationAutoloader', 'autoload'
        ));
    }
    
    /**
     * This will initialize the bootstrap files where the system bootstrap is used
     * for system processes and the normal bootstrap is called from the
     * application
     * 
     * @access public
     * @static
     * @return void
     */
    public static function _initBootstrap() 
    {
        self::_initPreBootstrap();
        
        if(file_exists(APPLICATION_PATH.'bootstrap.php')) {
            require_once APPLICATION_PATH.'bootstrap.php';
            $bootstrap = new Bootstrap();
        }
    }
    
    /**
     * @see Bwork_Application::_initBootstrap
     */
    public static function _initPreBootstrap() 
    {
        $bootstrap = new Bwork_Bootstrap_Bootstrap();
    }

    /**
     * Attempts to perform some checks for a stable run of the framework
     *
     * @access public
     * @static
     * @throws RuntimeException
     * @return void
     */
    public static function runTimeChecks()
    {
        if(defined('APPLICATION_PATH') === false 
            || defined('LIBRARY_PATH') === false) {
            throw new RuntimeException ('APPLICATION_PATH And LIBRARY_PATH has to be defined for a stable run.');
        }
    }

    /**
     * Attempts to set a handler for uncaught exceptions
     *
     * @static
     * @access public
     * @return void
     */
    public static function initExceptionHandler()
    {
        require_once 'bwork/exception/handler.php';
        set_exception_handler(array("Bwork_Exception_Handler", "onException"));
    }

    
    /**
     * The main application function used to dispatch the project
     * 
     * @static
     * @access public
     * @return void
     */
    public static function Run() 
    {
        self::runTimeChecks();
        self::initExceptionHandler();

        self::_initAutoloader();
        self::_initBootstrap();
        
        $router = Bwork_Core_Registry::getInstance()->getResource('Bwork_Router_Router');
        $router->route();
        
        self::Dispatch($router);
    }

    /**
     * @see Bwork_Application::Run
     * @param Bwork_Router_Router $router
     * @return void
     */
    public static function Dispatch(Bwork_Router_Router $router) 
    {
        $dispatcher = new Bwork_Controller_Dispatcher();
        $dispatcher->dispatch($router);
    }
    
}