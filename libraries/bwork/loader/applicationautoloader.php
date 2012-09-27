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
 * This autoloader attempts to load the given class, but is only capable of loading
 * either models or value objects.
 *
 * @package Bwork
 * @subpackage Bwork_Loader
 * @version v 0.3
 */
require_once 'bwork/loader/autoloader.php';
require_once 'bwork/loader/exception.php';
class Bwork_Loader_ApplicationAutoloader implements Bwork_Loader_Autoloader
{

    /**
     * Main method for loading Models and ValueObject
     *
     * @see Bwork_Loader_Interface::autoload()
     * @access public
     * @static
     * @param string $className
     * @throws Bwork_Loader_Exception
     * @return void
     */
    public static function autoload($className)
    {
        $className = strtolower($className);

        if(substr($className, -5) == 'model') {
            $fileName  = substr($className, 0, strpos($className, 'model')) . '.php';

            self::load($fileName, 'model');
        }
        elseif(substr($className, -2) == 'vo') {
            $fileName  = substr($className, 0, strpos($className, 'vo')) . '.php';

            self::load($fileName, 'vo');
        }
        else {
            throw new Bwork_Loader_Exception(sprintf('Class %s could not be loaded by the autoloader.', $className));
        }
    }

    /**
     * This method attempts to locate and load a file based on its type 
     * and will give higher priority to modules and fallback on normal 
     * Models or Value objects
     * 
     * @access public
     * @static
     * @param string $filename
     * @param string $type model|vo
     * @throws Bwork_Loader_Exception
     * @return void
     */
    public static function load($filename, $type)
    {
        $registry = Bwork_Core_Registry::getInstance();
        $config   = $registry->getResource('Bwork_Config_Confighandler');
        $router   = $registry->getResource('Bwork_Router_Router');

        if(($module = $router->module) !== null) {
            $filename     = str_replace($module.'_', '', $filename);
            $pathToModule = $config->get('module_path').$module . DIRECTORY_SEPARATOR;
            $moduleConfig = $config->get($module);
            $pathToFile   = $pathToModule.$moduleConfig[$type . '_path'];

            if(self::fileExists($pathToFile.$filename)) {
                require_once $pathToFile.$filename;
                return;
            }
        }

        $path = $config->get($type . '_path');
        if(self::fileExists($path.$filename)) {
            require_once $path.$filename;
            return;
        }
        else {
            throw new Bwork_Loader_Exception(
                sprintf('File(%s) [%s] could not be found in any of the checked locations.', $type, $filename
            ));
        }
    }

    /**
     * This methods will perform checks if the given file exists and is readable
     * 
     * @access public
     * @static
     * @param string $file
     * @return void
     */
    public static function fileExists($file)
    {
        return file_exists($file) && is_file($file) && is_readable($file);
    }

}