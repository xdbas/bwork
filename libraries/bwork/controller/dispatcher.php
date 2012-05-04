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
 * Dispatcher
 *
 * This class attempts to dispatch a specific controller as gained by the router
 *
 * @package Bwork
 * @subpackage Bwork_Controller
 * @version v 0.3
 */
class Bwork_Controller_Dispatcher {
    
    /**
     * This will dispatch a controller and will perform some checks to prevent 
     * failing
     * @param Bwork_Router_Router $router 
     * @access public
     * @return void
     */
    public function dispatch(Bwork_Router_Router $router) {
        
        $config = Bwork_Core_Registry::getInstance()->getResource('Bwork_Config_Confighandler');    

        $controller = $router->controller;
        $action     = $router->action;
        $module     = $router->module;

        if(empty($controller)) {
            throw new Bwork_Exception_ControllerException('Controller was not set by the router.');
        }
        
        if(empty($router->action)) {
            throw new Bwork_Exception_ControllerException('Action was not set by the router.');
        }
        
        $controllerName = $controller.'Controller';
        $filename       = $controller.'.php';
        if(isset($module)) {
            $configModule   = $config->get($module);
            $controllerPath = $config->get('module_path').strtolower($module).DIRECTORY_SEPARATOR.$configModule['controller_path'];
        }
        else {
            $controllerPath = $config->get('controller_path');
        }
        
        if(file_exists($controllerPath.$filename) == false) {
            throw new Exception(sprintf('%s does not exists', $controllerPath.$filename));
        }
        require_once $controllerPath.$filename;
        
        $controllerClass = new $controllerName();
        if($controllerClass instanceof Bwork_Controller_Action == false) {
            throw new Bwork_Exception_ControllerException(sprintf('%s have to be an instance of Bwork_Controller_Action', $controllerName));
        }

        $controllerClass->invoke($router);
        $controllerClass->getResponse()->outputStatus();
    }
    
}