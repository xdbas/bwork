<?php
/**
 * Bwork Framework
 *
 * @package Bwork
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
 * @version v 0.2
 */
class Bootstrap extends Bwork_Bootstrap_AbstractBootstrap {

    /**
     *  
     * 
     * 
     */
    public function _initConfig()
    {
        $config = Bwork_Core_Registry::getInstance()
                    ->getResource('Bwork_Config_Confighandler')
                    ->loadFile('route.php');
    }

    public function _initLayout()
    {
        $layout = new Bwork_Layout_Default();
        $layout->setLayout('layout.php');

        return new Bwork_Bootstrap_Alias('Bwork_Layout_ILayout', $layout);
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