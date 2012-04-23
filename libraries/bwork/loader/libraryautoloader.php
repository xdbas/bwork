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
 * LibraryAutoloader
 *
 * This autoloader attempts to load the given class, but is only capeable of loading
 * files within a library.
 *
 * @package Bwork
 * @subpackage Bwork_Loader
 * @version v 0.1
 */
require_once 'bwork/loader/autoloader.php';
class Bwork_Loader_LibraryAutoloader implements Bwork_Loader_Autoloader
{

	/**
	 * @see Bwork_Loader_Interface::autoload()
	 */
	public static function autoload($className)
	{
		$filePath     = str_replace('_', DIRECTORY_SEPARATOR, strtolower($className)) . '.php';
		$includePaths = explode(PATH_SEPARATOR, get_include_path());

		foreach($includePaths as $includePath) {
			if(file_exists($includePath.$filePath) === true) {
				require_once $includePath.$filePath;
				break;
			}
		}
	}

}