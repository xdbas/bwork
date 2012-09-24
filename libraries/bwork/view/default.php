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
 * @version v 0.2
 */
class Bwork_View_Default implements Bwork_View_View
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
     * @param string $template
     * @access public
     * @return Bwork_View_Default
     */
    public function __construct($template = null)
    {
        if($template === null) {
            $router = Bwork_Core_Registry::getInstance()->getResource('Bwork_Router_Router');

            $this->setView($router->controller.DIRECTORY_SEPARATOR.$router->action);
        }
        else {
            $this->setView($template);
        }
    }
    
    /**
     * This method attempts to check if a view file exists with support for 
     * module paths. It only checks on the initialized module gathered from Routing
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

        $defaultViewExtensions = $config->exists('default_view_extensions')
            ? $config->get('default_view_extensions')
            : array($config->get('default_view_extension'));

        if(($module = $router->module) !== null) {
            $pathToModule = $config->get('module_path').strtolower($module) . DIRECTORY_SEPARATOR;
            $moduleConfig = $config->get($module);
            $path         = $pathToModule.$moduleConfig['scripts_path'];

            if(($file = $this->loopThroughLocations($path.$view, $defaultViewExtensions)) !== null) {
                $this->view = $file;
                 return;
            }
        }
        else {
            if(($file = $this->loopThroughLocations($config->get('scripts_path').$view, $defaultViewExtensions)) !== null) {
                $this->view = $file;
                return;
            }

            throw new Bwork_View_Exception(
                sprintf('View [%s] could not be found with any of the following extensions [%s]',
                    $view,
                    implode(',', $defaultViewExtensions)
                )
            );
        }
    }

    /**
     * This function is used to check different locations for a view file and return its filename and path on success
     *
     * @param string $viewPath
     * @param array $extensions
     * @return string||null
     */
    public function loopThroughLocations($viewPath, array $extensions)
    {
        foreach($extensions as $ext) {
            if(Bwork_Loader_ApplicationAutoloader::fileExists($viewPath.'.'.$ext) === true) {
                return $viewPath.'.'.$ext;
            }
        }

        return;
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
     * This will assign variables from an associative array
     *
     * @param array $variables
     * @throws Bwork_View_Exception
     * @access public
     * @return void
     */
    public function assignArray($variables)
    {
        if(is_array($variables) == false
            && $variables instanceof Traversable == false) {
            throw new Bwork_View_Exception('assignArray can only handle array or Traversable input');
        }

        foreach($variables as $key => $value) {
            $this->assign($key, $value);
        }
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