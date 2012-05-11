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
 * from a bootstrap return a Bootstrap_Alias.
 *
 * @package Bwork
 * @subpackage Bwork_Bootstrap
 * @version v 0.2
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
     * Holds information wether it should override or not
     * 
     * @var int Bwork_Core_Registry::NO_OVERRIDING||Bwork_Core_Registry::OVERRIDE
     * @access public
     */
    public $override;
    
    /**
     * This is the constructor function used to assign the alias name for its 
     * object
     * 
     * @param string $name
     * @param object $object 
     * @param int $override
     * @return Bwork_Bootstrap_Alias
     */
    public function __construct($name, $object, $override = Bwork_Core_Registry::NO_OVERRIDING)
    {
        $this->name     = $name;
        $this->object   = $object;
        $this->override = $override;
    }
    
}
