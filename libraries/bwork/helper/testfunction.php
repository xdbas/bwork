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
 * TestFunction
 *
 * This is a dummy Helper Function
 *
 * @package Bwork
 * @subpackage Bwork_Helper
 * @version v 0.1
 */
class Bwork_Helper_TestFunction
{
    /**
     * Var stores the string
     *
     * @var String $var
     */
    public $var;

    /**
     * Test function which sets a string
     *
     * @return Bwork_Helper_TestFunction
     */
    public function testFunction()
    {
        $this->var = 'string';
        return $this;
    }

    /**
     * Test function which rewrites string
     *
     * @return Bwork_Helper_TestFunction
     */
    public function rewrite()
    {
        $this->var = 'rewrote it';
        return $this;
    }

    /**
     * Called on class to string
     *
     * @return String
     */
    public function __toString()
    {
        return $this->var;
    }
    
}