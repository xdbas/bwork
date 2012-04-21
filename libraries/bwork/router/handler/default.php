<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Router_Handler
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Default
 *
 * This class is a handler for the router and will attempt to resolve routes via
 * the config class
 *
 * @package Bwork
 * @subpackage Bwork_Router_Handler
 * @version v 0.1
 */
final class Bwork_Router_Handler_Default implements Bwork_Router_Handler_Interface {
    
    /**
     * Will store the parameter gained when resolving a route
     * @var array
     */
    public $params;
    
    /** 
     * @see Bwork_Router_Handler_Interface::checkRoute()
     */
    public function checkRoute(array $url) {
        $url = implode('/', $url);
        $config = Bwork_Core_Registry::getInstance()->getResource('Bwork_Config_Confighandler');
        
        if($config->exists('route')) {
            $routes = $config->get('route');
            if(array_key_exists($url, $routes)) {
                $this->params = $routes[$url];
                return true;
            }
        }
        
        return false;
    }
    
    /** 
     * @see Bwork_Router_Handler_Interface::getParams()
     */
    public function getParams() {
        return $this->params;
        
    }
}
