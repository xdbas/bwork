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
 * PreBootstrap
 *
 * This class will initialize a few system processes that need saving in the
 * registry object and should therefore not be executed by the user.
 *
 * @package Bwork
 * @subpackage Bwork_Bootstrap
 * @uses Bwork_Bootstrap_Bootstrap
 * @version v 0.1
 */
class Bwork_Bootstrap_PreBootstrap extends Bwork_Bootstrap_Bootstrap {
    
    /**
     * This will create the Http Request object
     * @access public
     * @return Bwork_Http_Request
     */
    public function _initHttpRequest() {
        $httpRequest = new Bwork_Http_Request();
        
        return $httpRequest;
    }
    
    /**
     * This create the Http Response object
     * @access public
     * @return Bwork_Http_Response 
     */
    public function _initHttpResponse() {
        $httpResponse = new Bwork_Http_Response();
        
        return $httpResponse;
    }
    
    /**
     * This will create the Config handler and assign default parsers.
     * @access public
     * @return Bwork_Config_Confighandler 
     */
    public function _initConfig() {
        $config = new Bwork_Config_Confighandler();
        
        $config->setParser("php", new Bwork_Config_Parser_PHPConfigParser())
               ->setParser("xml", new Bwork_Config_Parser_XMLConfigParser())
               ->setParser("ini", new Bwork_Config_Parser_IniConfigParser());
        
        return $config;
    }
    
    /**
     * This will create the router object and assign the default handler
     * @access public
     * @return Bwork_Router_Router 
     */
    public function _initRouter() {
        $router = new Bwork_Router_Router(
                Bwork_Core_Registry::getInstance()
                ->getResource("Bwork_Http_Request")
        );
        $router->setHandler(new Bwork_Router_Handler_Default());
        
        return $router;
    }
    
}