<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Router
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Interface
 *
 * The interface for Route handlers
 *
 * @package Bwork
 * @subpackage Bwork_Router
 * @version v 0.1
 */
interface Bwork_Router_Handler_Interface {
    
    /**
     * Will attempt to resolve if there is a specified route set for parameter $url
     * @param Array $url
     * @return boolean
     */
    public function checkRoute(array $url);
    
    /**
     * Will return the controller/action/mockparams parameters in array format
     * this method will only get called when checkRoute returns true
     * 
     * Example:
     * <code>
     * return array(
     *  'controller'    => 'Controllername',
     *  'action'        => 'ActionName',
     *  'mockParams'    => array('1', '2')
     * );
     * </code>
     * @return array
     */
    public function getParams();
    
}