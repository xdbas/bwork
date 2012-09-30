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
 * @version v 0.4
 */
class Bwork_Core_Registry extends ArrayObject
{
    const NO_OVERRIDING = 1;
    const OVERRIDING    = 2;
    
    /**
     * Holds an instance of Bwork_Core_Registry
     *
     * @var object $instance
     */
    private static $instance;
    
    /**
     * Used to return an instance of the class
     * 
     * @access public
     * @static
     * @return Bwork_Core_Registry
     */
    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    /**
     * Magic method to retrieve a resource
     *
     * @see Bwork_Core_Registry::getResource()
     * @param string $class_name
     * @return object
     */
    public function __get($class_name)
    {
        return $this->getResource($class_name);
    }

    /**
     * Magic method set, to set a resource
     *
     * @see Registry_Core_Registry::setResource ()
     * @param string $name
     * @param mixed $object
     */
    public function __set($name, $object)
    {
        $this->setResource($object);
    }

    /**
     * Used to retrieve an object from the array object Storage
     *
     * @param $class_name
     * @throws RuntimeException
     * @internal param string $key
     * @access public
     * @return object
     */
    public function getResource($class_name)
    {
        if($this->resourceExists(strtolower($class_name)) === false) {
            throw new RuntimeException(sprintf('Class [%s] was not found in Registry.', $class_name));
        }
        
        return $this->offsetGet(strtolower($class_name));
    }

    /**
     * Used to add an object to the object array
     *
     * @param object $object
     * @param string $alias
     * @param int $override
     * @throws RuntimeException
     * @access public
     * @return Bwork_Core_Registry
     */
    public function setResource($object, $alias = null, $override = self::NO_OVERRIDING)
    {
        if(is_object($object) === false) {
            throw new RuntimeException('Resource is not an object.');
        }

        $name = is_null($alias) || is_string($alias) == false
            ? strtolower(get_class($object))
            : strtolower($alias);
        
        if(self::NO_OVERRIDING == $override
            && $this->resourceExists($name)) {
            throw new RuntimeException(sprintf('Class: [%s] already exists in Registry.', $name));
        }
        
        $this->offsetSet($name, $object);
        
        return $this;
    }
    
    /**
     * Checks if class name exists in Bwork_Core_Registry::$objects
     * 
     * @param string $class_name
     * @access public
     * @return boolean 
     */
    public function resourceExists($class_name)
    {
        return $this->offsetExists(strtolower($class_name));
    }
    
}