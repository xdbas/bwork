<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Core
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Registry
 *
 * This will store objects and act like a singleton for every stored object
 *
 * @package Bwork
 * @subpackage Bwork_Core
 * @version v 0.3
 */
class Bwork_Core_Registry {
        
    /**
     * Holder for stored objects
     * @var array objects
     */
    private $objects = array();
    
    /**
     * Holds an instance of Bwork_Core_Registry
     * @var object $instance
     */
    private static $instance;
    
    /**
     * Used to return an instance of the class
     * @access public
     * @return object
     */
    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * Magic method to retrieve a resource
     * @see Bwork_Core_Registry::GetResource()
     * @param string $class_name
     * @access public
     * @return object
     */
    public function __get($class_name) {
        return $this->getResource($class_name);
    }
    
    /**
     *
     * @param string $name
     * @param object $object
     * @see Registry_Core_Registry::setResource 
     */
    public function __set($name, $object) {
        $this->set($object);
    }
     
    /**
     * Used to retrieve an object from the $objects array
     *
     * @param string $key
     * @access public
     * @return object
     */
    public function getResource($class_name) {
        if($this->exists(strtolower($class_name)) === false) {
            throw new Bwork_Exception_RegistryException(sprintf("Class: %s was not found in Registry.", $class_name));
        }
        
        return $this->objects[strtolower($class_name)];
    }
    
    /**
     * Used to add an object to the object array
     * 
     * @param object $object
     * @param string $alias
     * @access public
     * @return Bwork_Core_Registry
     */
    public function setResource($object, $alias = null) {
        if(is_object($object) === false) {
            throw new Bwork_Exception_RegistryException("Resource is not an object.");
        }

        $name = is_null($alias) || is_string($alias) == false? strtolower(get_class($object)) : strtolower($alias);
        
        if($this->exists($name)) {
            throw new Bwork_Exception_RegistryException(sprintf("Class: %s already exists in Registry.", $name));
        }
        
        $this->objects[$name] = $object;
        
        return $this;
    }
    
    /**
     * Checks if class name exists in Bwork_Core_Registry::$objects
     * @param string $class_name
     * @access public
     * @return boolean 
     */
    public function exists($class_name) {
        return array_key_exists($class_name, $this->objects);
    }
    
}