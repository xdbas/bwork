<?php

class Bwork_Helper_TestFunction {
    
    public $var;
    
    public function testFunction() {
        $this->var = "lalalala";
        return $this;
    }
 
    public function rewrite() {
        $this->var = "trololololo";
        return $this;
    }
    
    public function __toString() {
        return $this->var;
    }
    
}