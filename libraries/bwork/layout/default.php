<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Layout
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Default
 *
 * This class is used to create a specific wrapper around your regular view 
 * templates. This should be used to set returning layouts where you normally 
 * would include a header and footer. Note that a layout file should atleast 
 * have one line of specific coding.
 * 
 * Example:
 * <code>
 * <!DOCTYPE html>
 * <html>
 * <head></head>
 * <body>
 *  <?php echo $this->content; ?>
 * </body>
 * </html>
 * </code>
 *
 * @package Bwork
 * @subpackage Bwork_Layout
 * @version v 0.2
 */
class Bwork_Layout_Default implements Bwork_Layout_Layout
{
    
    /**
     * This will hold the layout template
     * 
     * @var string
     * @access protected 
     */
    protected $layout;
    
    /**
     * This will hold all variables
     * 
     * @var array $variables 
     * @access public
     */
    protected $variables = array();
    
    /**
     * This will hold the content retrieved from a possible view template
     * 
     * @var string
     * @access protected 
     */
    protected $content;

    /**
     * This method will attempt to set the layout variable and perform some
     * checks before doing so
     *
     * @param string $layout
     * @param null $module
     * @access public
     * @throws Bwork_Layout_Exception
     * @return Bwork_Layout_Default
     */
    public function setLayout($layout, $module = null)
    {
        $registry = Bwork_Core_Registry::getInstance();
        $config   = $registry->getResource('Bwork_Config_Confighandler');
        $router   = $registry->getResource('Bwork_Router_Router');
        
        if($module !== null) {
            if($registry->resourceExists('Bwork_Module_Manager') === false) {
                throw new Bwork_Layout_Exception('No module initialization has took place');
            }
            
            if($registry->getResource('Bwork_Module_Manager')->moduleExists($module) === false) {
                throw new Bwork_Layout_Exception(sprintf('Module [%s] has not yet been initialized', $module));
            }
            
            $pathToModule = $config->get('module_path').strtolower($module) . DIRECTORY_SEPARATOR;
            $moduleConfig = $config->get($module);
            $path         = $pathToModule.$moduleConfig['layouts_path'];

            if(Bwork_Loader_ApplicationAutoloader::fileExists(($file = $path.$layout)) === true) {
                $this->layout = $file;
                return $this;
            }
        }

        if(Bwork_Loader_ApplicationAutoloader::fileExists(($file = $config->get('layouts_path').$layout)) === true) {
            $this->layout = $file;
            return $this;
        }
        else {
            throw new Bwork_Layout_Exception(sprintf('Layout [%s] could not be found', $layout));
        }
    }
    
    /**
     * This will return the current layout
     * 
     * @access public
     * @return string 
     */
    public function getLayout()
    {
        return $this->layout;
    }
    
    /**
     * This will set the content variable
     * 
     * @param string $content 
     * @access public
     * @return Bwork_Layout_Default
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
    
    /**
     * This will return the current content
     * 
     * @access public
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * This will include the layout file which therefore should have added
     * possible view layout content
     * 
     * @access public
     * @return mixed
     */
    public function fetch()
    {
       ob_start();
       
       require_once $this->layout;
       $content = ob_get_contents();
       
       ob_end_clean();
       
       return $content;
    }
    
    /**
     * This will immediately attempt to display the layout template file
     *
     * @access public
     * @return void
     */
    public function display()
    {
        echo $this->fetch();
    }
    
    /**
     * This will merge set in the view with the layout variables
     * 
     * @param array $variables 
     * @access public
     * @return void
     */
    public function mergeVariables(array $variables)
    {
        $this->variables = array_merge($this->variables, $variables);
    }
    
    /**
     * This is the magic method used to retrieve assigned variables set in the
     * variables variable
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
     * This is the magic method used when a undefined method is called
     * this will try to retrieve a helper for this function and execute the
     * helper
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