<?php
/**
 * dummy file
 */
class Bwork_Helper_TestFunction
{
    
    public $var;
    
    public function testFunction()
    {
        $this->var = 'string';
        return $this;
    }
 
    public function rewrite()
    {
        $this->var = 'rewrote it';
        return $this;
    }
    
    public function __toString()
    {
        return $this->var;
    }
    
}