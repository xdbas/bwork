<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_View
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Default
 *
 * This class is used to handle regular view templates
 *
 * @package Bwork
 * @subpackage Bwork_View
 * @version v 0.1
 */
class Bwork_View_Default implements Bwork_View_IView {
    
    /**
     * Hold the name of the view file
     * @var string $view 
     * @access public
     */
    public $view;
    
    /**
     * This will hold all variables set by the abstract logic
     * @var array $variables 
     * @access public
     */
    public $variables = array();
    
    /**
     * TODO: Multiple Template Extensions
     * @param type $template 
     * @access public
     * @return void
     */
    public function __construct($template = null) {
        if($template == null) {
            $router = Bwork_Core_Registry::GetInstance()->getResource('Bwork_Router_Router');
            
           $template_name = $router->controller.DIRECTORY_SEPARATOR.$router->action;
           
           $this->view = $template_name.Bwork_Core_Registry::GetInstance()
                                            ->getResource('Bwork_Config_Confighandler')
                                            ->get('default_view_extension');
        } else {
            $this->view = $template;
        }
    }
    
    /**
     * This will add a key-value pair to the $variables variable
     * @param string $key
     * @param mixed $value 
     * @access public
     * @return void
     */
    public function assign($key, $value) {
        $this->variables[$key] = $value;
    }
    
    /**
     * This will return the $variables variable
     * @access public
     * @return array 
     */
    public function getVariables() {
        return $this->variables;
    }
    
    /**
     * This will include the view template that has been set and will clean all
     * contents from the page to return
     * @access public
     * @return string
     */
    public function fetch() {
        ob_start();
        
        require_once Bwork_Core_Registry::GetInstance()
                        ->getResource('Bwork_Config_Confighandler')
                        ->get('scripts_path')
                        .$this->view;
       
        $content = ob_get_contents();
        
        ob_end_clean();
        
        return $content;
    }
    
    /**
     * This will imidiatly attempt to display the view template file
     * @access public
     * @return void
     */
    public function display() {
        echo $this->fetch();
    } 
    
    /**
     * This is the magic method used to retrieve assigned variables set in the
     * variables variable
     * @param string $key
     * @access public
     * @return void 
     */
    public function __get($key) {
        return isset($this->variables[$key])? $this->variables[$key] : null;
    }
    
    /**
     * This is the magic mathod used when a undifined method is called
     * this will try to retrieve a helper for this function and execute the
     * helper
     * 
     * @param string $name
     * @param array $argument
     * @access public
     * @return object
     */
    public function __call($name, $arguments) {
        $helper = Bwork_Helper_Handler::retrieveHelper($name);
        return call_user_func_array(array($helper, $name), $arguments);
    }
    
}