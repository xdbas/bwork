<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Module
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Interface
 *
 * The interface for module managers
 *
 * @package Bwork
 * @subpackage Bwork_Module
 * @version v 0.1
 */
interface Bwork_Module_Module
{

    /**
     * Method used to load a single module
     *
     * @abstract
     * @param string $moduleName
     * @return self
     */
    public function addModule($moduleName);

    /**
     * Method used to initialize a loaded module
     *
     * @abstract
     * @param string $moduleName
     * @return void
     */
    public function initialize($moduleName);

}