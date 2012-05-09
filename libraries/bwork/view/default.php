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
 * @todo change Name of interface to new standard
 * @package Bwork
 * @subpackage Bwork_View
 * @version v 0.2
 */
class Bwork_View_Default implements Bwork_View_IView
{
    
    /**
     * Hold the name of the view file
     * 
     * @var string $view 
     * @access protected
     */
    protected $view;
        
    /**
     * This will hold all variables set by the abstract logic
     * 
     * @var array $variables 
     * @access protected
     */
    protected $variables = array();
    
    /**
     * The constructor method that is used to set a specific view file, will 
     * when template param is null use the default values
     * 
     * TODO: Multiple Template Extensions
     * @param type $template 
     * @access public
     * @return void
     */
    public function __construct($template = null)
    {
        if($template === null) {
            $registry = Bwork_Core_Registry::getInstance();
            $config   = $registry->getResource('Bwork_Config_Confighandler');
            $router   = $registry->getResource('Bwork_Router_Router');

            $template_name = $router->controller.DIRECTORY_SEPARATOR.$router->action;

            $this->setView($template_name.$config->get('default_view_extension'));
        }
        else {
            $this->setView($template);
        }
    }
    
    /**
     * This method attempts to check if a view file exists with support for 
     * module paths, with and extra fallback to the normal scripts path.
     * 
     * @access public
     * @param string $view
     * @throws Bwork_View_Exception
     * @return void
     */
    public function setView($view)
    {
        $registry = Bwork_Core_Registry::getInstance();
        $config   = $registry->getResource('Bwork_Config_Confighandler');
        $router   = $registry->getResource('Bwork_Router_Router');
        
        if(($module = $router->module) !== null) {
            $pathToModule = $config->get('module_path').strtolower($module) . DIRECTORY_SEPARATOR;
            $moduleConfig = $config->get($module);
            $path         = $pathToModule.$moduleConfig['scripts_path'];
            
            if(file_exists($path.$view) === true) {
                $this->view = $path.$view;
                return;
            }
        }
        
        if(file_exists(($path = $config->get('scripts_path')).$view)) {
            $this->view = $path.$view;
            return;
        }
        else {
            throw new Bwork_View_Exception(sprintf('View [%s] could not be found', $view));
        }
    }

    /**
     * This will add a key-value pair to the $variables variable
     * 
     * @param string $key
     * @param mixed $value 
     * @access public
     * @return void
     */
    public function assign($key, $value)
    {
        $this->variables[$key] = $value;
    }
    
    /**
     * This will return the $variables variable
     * 
     * @access public
     * @return array 
     */
    public function getVariables()
    {
        return $this->variables;
    }
    
    /**
     * This will include the view template that has been set and will clean all
     * contents from the page to return
     * 
     * @access public
     * @return string
     */
    public function fetch()
    {
        ob_start();
       
        require_once $this->view;
       
        $content = ob_get_contents();
        
        ob_end_clean();
        
        return $content;
    }
    
    /**
     * This will imidiatly attempt to display the view template file
     * 
     * @access public
     * @return void
     */
    public function display()
    {
        echo $this->fetch();
    } 
    
    /**
     * This is the magic method used from a view to retrieve assigned variables 
     * set in the $variables variable
     * 
     * @param string $key
     * @access public
     * @return mixed
     */
    public function __get($key)
    {
        return isset($this->variables[$key])? $this->variables[$key] : null;
    }
    
    /**
     * This is the magic method used when a undifined method is called from a 
     * view file and will attempt to retrieve and execute a helper for this
     * method
     * 
     * @param string $name
     * @param array $arguments
     * @access public
     * @return object
     */
    public function __call($name, $arguments)
    {
        $helper = Bwork_Helper_Handler::retrieveHelper($name);
        return call_user_func_array(array($helper, $name), $arguments);
    }
    
}