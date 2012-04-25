<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Module
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Manager
 *
 * This class is used to controll module loading and getting
 *
 * @package Bwork
 * @subpackage Bwork_Module
 * @version v 0.1
 */
class Bwork_Module_Manager 
    implements Bwork_Module_Module, 
               ArrayAccess, 
               Traversable
{
    
    public $modules = array();

    public function addModule($moduleName)
    {
        if($this->offsetExists($moduleName)) {
            throw new Bwork_Module_Exception(sprintf('Module %s is already loaded.', $moduleName));
        }

        $this->checkModulePath($moduleName);

        return $this;   
    }

    protected function checkModulePath()
    {

    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->modules[] = $value;
        } else {
            $this->modules[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->modules[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->modules[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->modules[$offset]) ? $this->modules[$offset] : null;
    }

}