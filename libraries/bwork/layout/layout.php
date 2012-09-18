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
 * This class is used to handle regular layout templates
 *
 * @package Bwork
 * @subpackage Bwork_Layout
 * @version v 0.2
 */
interface Bwork_Layout_Layout
{

    /**
     * This method will attempt to set a layout template
     *
     * @param string $layout
     * @param null $module
     * @access public
     * @return Bwork_Layout_Default
     */
    public function setLayout($layout, $module = null);

    /**
     * This will return the current layout
     *
     * @access public
     * @return string
     */
    public function getLayout();

    /**
     * This will set the content variable
     *
     * @param string $content
     * @access public
     * @return Bwork_Layout_Default
     */
    public function setContent($content);

    /**
     * This will return the current content
     *
     * @access public
     * @return string
     */
    public function getContent();

    /**
     * This will include the layout file which therefore should have added
     * possible view layout content
     *
     * @access public
     * @return mixed
     */
    public function fetch();

    /**
     * This will merge set in the view with the layout variables
     *
     * @param array $variables
     * @access public
     * @return void
     */
    public function mergeVariables(array $variables);

}