<?php 
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Config
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * @package Bwork
 * @subpackage Bwork_Config
 * @version v 0.1
 */
interface Bwork_Config_Handler
{
    
    /**
     * This will check the file for it's file type and will check if there is an
     * handler set for this file type, and will on success parse this file and
     * merge its config data with the settings array
     * 
     * @access public
     * @param string $file 
     * @throws Bwork_Config_Exception
     * @return Bwork_Config_Confighandler
     */
    public function loadFile($file);

    /**
     * This will attempt to merge the input data with the settings array
     * 
     * @access public
     * @param array $data
     * @throws Bwork_Config_Exception
     * @return void
     */
    public function loadArray(array $data);
    
    /**
     * Will retrieve a setting from Bwork_Config::$settings
     * 
     * @access public
     * @param string $key
     * @throws Bwork_Config_Exception
     * @return void
     */
    public function get($key);
        
}