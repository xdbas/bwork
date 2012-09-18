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
 * Interface
 *
 * The interface view handlers
 *
 * @package Bwork
 * @subpackage Bwork_View
 * @version v 0.1
 */
interface Bwork_View_View
{

    /**
     * This method is used to assign variables to save for usage in a view
     *
     * @abstract
     * @param string $key
     * @param string $value
     * @return void
     */
    public function assign($key, $value);

    /**
     * This is the main method to fetch the contents of a view
     *
     * @abstract
     * @return string Content
     */
    public function fetch();

    /**
     * This is a method used to instantly attempt to echo the content
     *
     * @abstract
     * @return void
     */
    public function display();
    
}