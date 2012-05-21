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
 * @version v 0.2
 */
final class Bwork_Router_Handler_Module 
    implements Bwork_Router_Handler
{
    
    /**
     * Will store the parameter gained when resolving a route
     * 
     * @var array
     * @access protected
     */
    protected $params;

    /**
     * Will check if a route is set for this uri\
     *
     * @see Bwork_Router_Handler_Interface::checkRoute()
     * @param array $uri
     * @return bool
     */
    public function checkRoute(array $uri)
    {
        $config        = Bwork_Core_Registry::getInstance()->getResource('Bwork_Config_Confighandler');
        $moduleManager = Bwork_Core_Registry::getInstance()->getResource('Bwork_Module_Manager');

        $modules = $moduleManager->getModules();

        if(count($modules) < 1
            || count($uri) < 1) {
            return false;
        }

        foreach($modules as $module) {
            if($module == strtolower($uri[0])) {
                $moduleManager->initialize($module);
                $configModule = $config->get($module);

                $this->params['controller'] = isset($uri[1])? $uri[1] : $configModule['default_controller'];
                $this->params['action'] = isset($uri[2])? $uri[2] : $configModule['default_action'];
                $this->params['mockParams'] = array();
                $this->params['module']  = $module;
                return true;
            }
        }   	
    }

    /**
     * Will return the resolved Params used for dispatching
     *
     * @see Bwork_Router_Handler_Interface::getParams()
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

}
