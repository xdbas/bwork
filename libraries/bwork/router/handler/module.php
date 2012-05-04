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
 * Module
 *
 * A Router handler which will check if the segments match a module
 *
 * @package Bwork
 * @subpackage Bwork_Router_Handler
 * @version v 0.1
 */
final class Bwork_Router_Handler_Module implements Bwork_Router_Handler_Interface
{
    
    /**
     * Will store the parameter gained when resolving a route
     * @var array
     */
    public $params;
    
    /** 
     * @see Bwork_Router_Handler_Interface::checkRoute()
     */
    public function checkRoute(array $url)
    {
        $config        = Bwork_Core_Registry::getInstance()->getResource('Bwork_Config_Confighandler');
        $moduleManager = Bwork_Core_Registry::getInstance()->getResource('Bwork_Module_Manager');

        $modules = $moduleManager->getModules();

        if(count($modules) < 1
            || count($url) < 1) {
            return false;
        }

        foreach($modules as $module) {
            if($module == $url[0]) {
                $configModule = $config->get($module);

                $this->params['controller'] = isset($url[1])? $url[1] : $configModule['default_controller'];
                $this->params['action'] = isset($url[2])? $url[2] : $configModule['default_action'];
                $this->params['mockParams'] = array();
                $this->params['module']  = $module;

                return true;
            }
        }
    }

    /** 
     * @see Bwork_Router_Handler_Interface::getParams()
     */
    public function getParams() {
        return $this->params;
    }

}
