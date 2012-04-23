<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Bootstrap
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Alias
 *
 * This class will is used when an object should be placed in the registry 
 * under a different name than its standard, instead of returning an object 
 * from a boostrapper return a Bootstrap_Alias.
 *
 * @package Bwork
 * @subpackage Bwork_Bootstrap
 * @version v 0.1
 * @abstract
 */
class Bwork_Bootstrap_Alias
{
    
    /**
     * This will hold the Alias name of the object
     * 
     * @var string
     * @access public
     */
    public $name;
    
    /**
     * This will hold the object
     * 
     * @var object
     * @access public
     */
    public $object;
    
    /**
     * This is the constructor function used to assign the alias name for its 
     * object
     * 
     * @param type $name
     * @param type $object 
     */
    public function __construct($name, $object)
    {
        $this->name = $name;
        $this->object = $object;
    }
    
}
