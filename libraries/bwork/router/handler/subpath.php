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
 * SubPath
 *
 * A Router handler which will check if the segments match a subdirectory 
 * within the controller folder and will change its controller and action 
 * based on that information.
 *
 * @package Bwork
 * @subpackage Bwork_Router_Handler
 * @version v 0.1
 * @deprecated
 */
final class Bwork_Router_Handler_SubPath implements Bwork_Router_Handler_Interface
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
        $config = Bwork_Core_Registry::getInstance()->getResource('Bwork_Config_Confighandler');

        if(count($url) <= 0) {
            return false;
        }

        $controllerPath = $config->get('controller_path');
        $subPath        = null;

        $i = 0;
        foreach($url as $param) {
            if(is_dir($controllerPath.$subPath.$param) === true) {
                $subPath .= $param . DIRECTORY_SEPARATOR;
            }
            else {
                $this->resolveParams($url, $i);
                break;
            }

            $i++;
        }

        $this->params['subPath'] = $subPath;
        $this->params['mockParams'] = array();

        if(array_key_exists('controller', $this->params) == false 
            || array_key_exists('action', $this->params) == false) {
            $this->resolveParams($url, $i);
        }

        return true;
    }

    /**
     * Will attempt to resolve the controller file and action method 
     * from the url params.
     * 
     * @param array $url
     * @param int $from From which item the subPaths stops
     */
    public function resolveParams(array $url, $from)
    {
        $config = Bwork_Core_Registry::getInstance()->getResource('Bwork_Config_Confighandler');

        $this->params['controller'] = isset($url[$from])? $url[$from] : $config->get('default_controller');
        $this->params['action']     = isset($url[($from+1)])? $url[($from+1)] : $config->get('default_action');
    }
    
    /** 
     * @see Bwork_Router_Handler_Interface::getParams()
     */
    public function getParams()
    {
        return $this->params;
    }
}