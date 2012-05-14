<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Loader
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Interface
 *
 * The interface for an autoloader
 *
 * @package Bwork
 * @subpackage Bwork_Loader
 * @version v 0.1
 */
interface Bwork_Loader_Autoloader
{
	/**
	 * This is the main method which attempts to resolve the correct path and file name
	 * and attempts to require this file.
	 * 
	 * @access public
     * @static
	 * @var string $className
	 * @return void
	 */
	public static function autoload($className);
}