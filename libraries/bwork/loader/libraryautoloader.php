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
 * This autoloader attempts to load the given class, but is only capable of loading
 * files within a library.
 *
 * @package Bwork
 * @subpackage Bwork_Loader
 * @version v 0.2
 */
require_once 'bwork/loader/autoloader.php';
class Bwork_Loader_LibraryAutoloader implements Bwork_Loader_Autoloader
{

    /**
     * Main method for loading library files
     *
     * @see Bwork_Loader_Interface::autoload()
     * @access public
     * @static
     * @param string $className
     * @return void
     */
	public static function autoload($className)
	{
		$filePath     = str_replace('_', DIRECTORY_SEPARATOR, strtolower($className)) . '.php';
		$includePaths = explode(PATH_SEPARATOR, get_include_path());

		if(($file = self::fileExists($filePath)) !== false) {
			require_once $file;
			return;
		}

		foreach($includePaths as $includePath) {
			if(file_exists($includePath.$filePath) === true) {
				require_once $includePath.$filePath;
				break;
			}
		}
	}

	/**
	 * This method is used to check if a file exist within the library folder and
	 * is used before relying on the include paths. Allot of servers don't allow
	 * you to attempt a file_exists command on pre initialized include paths.
	 * 
	 * @access public
	 * @static
	 * @param string $filename
	 * @return string
	 */
	public static function fileExists($filename)
    {
        if (file_exists($filename)) {
            return $filename;
        }

    	$originalPathInfo = pathinfo($filename);
    	$file = $originalPathInfo['basename'];

    	$dir = dirname($filename);
        if(($files = glob(LIBRARY_PATH.$dir.DIRECTORY_SEPARATOR.'*')) !== false) {
        	foreach($files as $key => $value) {
        		$pathinfo = pathinfo($value);

        		if($pathinfo['basename'] == $file) {
        			return $filename;
        		}
        	}
        }

        return false;
    }

}