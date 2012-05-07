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
 * Autoload
 *
 * This class is called when the called class has not yet been found and 
 * attempts to require the class its file by resolving the namespace
 *
 * @package Bwork
 * @subpackage Bwork
 * @version v 0.1
 * @deprecated
 */
class Bwork_Autoload {
    
    /**
     * Holds the singleton instance of Autoload
     * 
     * @static
     * @access private
     * @var object $instance 
     */
    private static $instance;
    
    /**
     * This is a singleton function of the autoloader to return the correct 
     * instance
     * 
     * @access public
     * @static
     * @return Bwork_Autoload
     */
    public static function init() {
        if(self::$instance == NULL) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * This is the constructor function which initializes the autoload methods
     * 
     * @access public
     * @return void
     */
    public function __construct() {
        spl_autoload_register(array(
            $this, 'autoload'
        ));
    }
    
    /**
     * This method is used to autoload models
     * 
     * @access private
     * @param string $class
     * @return void
     */
    private function autoload($class) {
        $class = strtolower($class);
        $path = str_replace('_', DIRECTORY_SEPARATOR, $class.'.php');

        if(substr($class, -5) == 'model') {
            $class = substr($class, 0 , strpos($class, 'model')).'.php';
            if(file_exists(APPLICATION_PATH.'models'.DIRECTORY_SEPARATOR.$class)) {
                require_once APPLICATION_PATH.'models'.DIRECTORY_SEPARATOR.$class;
            }
        }
        else if(file_exists(APPLICATION_PATH.$path)) {
            require_once APPLICATION_PATH.$path;
        } 
        else if(file_exists(LIBRARY_PATH.$path)) {
            require_once LIBRARY_PATH.$path;
        } 
        else {
            throw new Exception(sprintf('[%s] Was not found.', $path));
        }
    }
    
}