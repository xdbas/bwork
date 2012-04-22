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
 * ApplicationAutoloader
 *
 * This autoloader attempts to load the given class, but is only capeable of loading
 * either models or value objects.
 *
 * @package Bwork
 * @subpackage Bwork_Loader
 * @version v 0.1
 */
require_once 'bwork/loader/interface.php';
require_once 'bwork/loader/exception.php';
class Bwork_Loader_ApplicationAutoloader implements Bwork_Loader_Interface
{

	/**
	 * @see Bwork_Loader_Interface::autoload()
	 */
	public static function autoload($className)
	{
		$config    = Bwork_Core_Registry::getInstance()->getResource('Bwork_Config_Confighandler');
		$className = strtolower($className);
        
		$modelPath = $config->get('model_path');
		$voPath    = $config->get('vo_path');
		
		if(substr($className, -5) == 'model') {
			$fileName  = substr($className, 0, strpos($className, 'model')) . '.php';

			if(file_exists($modelPath.$fileName)) {
				require_once $modelPath.$fileName;
				return;
			}
		}
		elseif(substr($className, -2) == 'vo') {
			$fileName  = substr($className, 0, strpos($className, 'vo')) . '.php';
			
			if(file_exists($voPath.$fileName)) {
				require_once $voPath.$fileName;
				return;
			}
		}
		else {
			throw new Bwork_Loader_Exception(sprintf('Class %s could not be loaded by the autoloader.', $className));
		}
	}

}