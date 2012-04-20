<?php

class Bootstrap extends Bwork_Bootstrap_Bootstrap {
       
    public function _initConfig() {
        $config = Bwork_Core_Registry::getInstance()
                ->getResource('Bwork_Config_Confighandler')
                ->loadFile('general.php')
                ->loadFile('route.php');
    }
    
    public function _initLayout() {
        $layout = new Bwork_Layout_Default();
        $layout->setLayout('layout.php');

        return new Bwork_Bootstrap_Alias('Bwork_Layout_ILayout', $layout);
    }
    
    public function _initHelper() {
        Bwork_Helper_Handler::registerNamespace('Bwork_Helper');
    }
    
}