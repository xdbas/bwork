<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Helper
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Handler
 *
 * This class is used to handle helpers used in the view it will attempt to 
 * check for an existing helper and execute its main function.
 *
 * @package Bwork
 * @subpackage Bwork_Helper
 * @version v 0.1
 * @static
 */
class Bwork_Helper_Handler 
{
    
    /**
     * This will hold all the registered namespaces where the key will be used
     * as path and the value as its class namespace
     *
     * @var array $namespaces
     * @access protected
     * @static
     */
    protected static $namespaces = array();
    
    /**
     * This will hold all the executed helpers this is a sort of cache where the
     * helpers are stored to prevent double loading
     *
     * @var array $helpers
     * @access protected
     * @static
     */
    protected static $helpers = array();

    /**
     * This will attempt to resolve the namespace its path and therefor add it
     * to the namespaces class variable
     *
     * @param string $namespace
     * @throws Bwork_Helper_Exception
     * @static
     * @access public
     * @return void
     */
    public static function registerNamespace($namespace) 
    {
        if(in_array($namespace, self::$namespaces)) {
            throw new Bwork_Helper_Exception(sprintf('Namespace: %s was already registered.', $namespace));
        }
        
        $path = LIBRARY_PATH.str_replace('_', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
        if(self::checkPath($path) == false) {
            throw new Bwork_Helper_Exception(sprintf('Path: %s could not be found.', $path));
        }
        
        self::$namespaces[$namespace] = $path;
    }
    
    /**
     * This function will if a path exists
     *
     * @param string $path
     * @access public
     * @static
     * @return boolean
     */
    public static function checkPath($path) 
    {
        return is_dir(strtolower($path));
    }

    /**
     * This is the main function and will attempt to retrieve a helper
     *
     * @param string $helper
     * @throws Bwork_Helper_Exception
     * @access public
     * @static
     * @return object
     */
    public static function retrieveHelper($helper) 
    {
        if(self::isAssigned($helper) == false) {
            if(self::requireHelperFile($helper) == false) {
                throw new Bwork_Helper_Exception(sprintf('There was no helper found under the name %s', $helper));
            }
        }
        
        return self::$helpers[$helper];
    }
    
    /**
     * This will loop foreach namespace to check if a helper called from 
     * self::retrieveHelper exists
     *
     * @param string $helper
     * @access protected
     * @static
     * @return boolean 
     */
    protected static function requireHelperFile($helper) 
    {
        foreach(self::$namespaces as $namespace => $path) {
            if(file_exists(strtolower($path.$helper).'.php')) {
                require strtolower($path.$helper).'.php';
                
                if(class_exists($namespace.'_'.$helper)) {
                    $class_name = $namespace.'_'.$helper;
                    self::$helpers[$helper] = new $class_name();
                    return true;
                }                
            }
        }
        
        return false;
    }
    
    /**
     * This function will check if a helper class is already stored in 
     * self::$helpers
     *
     * @param string $helper
     * @access protected
     * @static
     * @return boolean 
     */
    protected static function isAssigned($helper) 
    {
        return array_key_exists($helper, self::$helpers);
    }
    
}