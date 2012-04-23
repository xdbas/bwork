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
     * This will initialize the bootstrappers where the prebootstrapper is used 
     * for system processes and the normal bootstrapper is called from the 
     * application
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
        $prebootstrap = new Bwork_Bootstrap_PreBootstrap();
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
        self::_initAutoloader();
        self::_initBootstrap();
        
        $router = Bwork_Core_Registry::getInstance()->getResource('Bwork_Router_Router');
        $router->route();
        
        self::Dispatch($router);
    }
    
    /**
     * @see Bwork_Application::Run
     * @param Bwork_Router_Router $router
     */
    public static function Dispatch(Bwork_Router_Router $router) 
    {
        $dispatcher = new Bwork_Controller_Dispatcher();
        $dispatcher->dispatch($router);
    }
    
}