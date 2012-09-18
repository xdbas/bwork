<?php

class Bootstrap extends Bwork_Bootstrap_AbstractBootstrap {
       
    public function _initConfig()
    {
        $config = Bwork_Core_Registry::getInstance()
                ->getResource('Bwork_Config_Confighandler')
                ->loadFile(APPLICATION_PATH.'config'.DIRECTORY_SEPARATOR.'route.php');
    }
    
    public function _initLayout()
    {
        $layout = new Bwork_Layout_Default();
        $layout->setLayout('layout.php');

        return new Bwork_Bootstrap_Alias('Bwork_Layout_Layout', $layout);
    }
    
    public function _initHelper()
    {
        Bwork_Helper_Handler::registerNamespace('Bwork_Helper');
    }

    public function _initModule()
    {
        $module = new Bwork_Module_Manager();
        $module->addModule('admin');

        return $module;
    }
}