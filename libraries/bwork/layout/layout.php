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
interface Bwork_Layout_Layout {

    /**
     * This method will attempt to set the layout variable and perform some
     * checks before doing so
     *
     * @abstract
     * @param string $layout
     * @param null $module
     * @access public
     * @throws Bwork_Layout_Exception
     * @return Bwork_Layout_Default
     */
    public function setLayout($layout);

    /**
     * @abstract
     * @return mixed
     */
    public function getLayout();

    /**
     * @abstract
     * @param $content
     * @return mixed
     */
    public function setContent($content);

    /**
     * @abstract
     * @return mixed
     */
    public function getContent();

    /**
     * @abstract
     * @return mixed
     */
    public function fetch();
}