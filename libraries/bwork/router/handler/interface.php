<?php

interface Bwork_Router_Handler_Interface {
    
    /**
     * Will attempt to resolve if there is a specified route set for parameter $url
     * @param $url string
     * @return boolean
     */
    public function checkRoute($url);
    
    /**
     * Will return the controller/action/mockparams parameters in array format
     * @return array
     */
    public function getParams();
    
}