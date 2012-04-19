<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Layout
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 */

/**
 * Default
 *
 * This class is used to give the opportunity the use a specific wrapper around
 * your regular view templates. This should be used to set returning layouts
 * where you normally would include a header and footer.
 *
 * @package Bwork
 * @subpackage Bwork_Layout
 * @version v 0.1
 */
class Bwork_Layout_Default implements Bwork_Layout_ILayout {
    
    /**
     * This will hold the file name of the layout
     * @var string
     * @access protected 
     */
    protected $layout;
    
    /**
     * This will hold all variables set by the abstract logic
     * @var array $variables 
     * @access public
     */
    protected $variables = array();
    
    /**
     * This will hold the content retrieved from a possible view template
     * @var string
     * @access protected 
     */
    protected $content;


    /**
     * This will attempt to set the layout variable
     * @param string $layout 
     * @access public
     */
    public function setLayout($layout) {
        $this->layout = $layout;
    }
    
    /**
     * This will return the current layout
     * @access public
     * @return string 
     */
    public function getLayout() {
        return $this->layout;
    }
    
    /**
     * This will set the content variable
     * @param string $content 
     * @access public
     * @return void
     */
    public function setContent($content) {
        $this->content = $content;
    }
    
    /**
     * This will return the current content
     * @acccess public
     * @return string
     */
    public function getContent() {
        return $this->content;
    }
    
    /**
     * This will include the layout file which therfore should have added
     * possible view layout content
     * @access public
     * @return string
     */
    public function fetch() {
       ob_start();
       
       require_once Bwork_Core_Registry::GetInstance()
                        ->getResource("Bwork_Config_Confighandler")
                        ->get("layouts_path")
                        .$this->layout;
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
     * This will merge variables with the variables variable
     * @param array $variables 
     * @access public
     * @return void
     */
    public function mergeVariables(array $variables) {
        $this->variables = array_merge($this->variables, $variables);
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