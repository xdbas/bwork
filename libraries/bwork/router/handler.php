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
interface Bwork_Router_Handler
{
    
    /**
     * Will attempt to resolve if there is a specified route set for parameter $url
     *
     * @param Array $uri
     * @return boolean
     */
    public function checkRoute(array $uri);
    
    /**
     * Will return the controller/action/module/mockparams parameters in object format
     * this method will only get called when checkRoute returns true. Either return
     * a Bwork_Router_Route- or StdClass object.
     * 
     * Example:
     * <code>
     * return Bwork_Router_Route(
     *  'Controllername',
     *  'ActionName',
     *  'modulename'
     *  array(1, 2)
     * );
     * </code>
     * @return Bwork_Router_Route
     */
    public function getParams();
    
}