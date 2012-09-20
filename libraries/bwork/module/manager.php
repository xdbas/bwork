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
 * Manager
 *
 * This class is used to control module loading and getting
 *
 * @package Bwork
 * @subpackage Bwork_Module
 * @version v 0.2
 */
class Bwork_Module_Manager implements Bwork_Module_Module
{
    
    /**
     * Will hold all the loaded modules
     * 
     * @access protected
     * @var Array $modules
     */
    protected $modules = array();

    /**
     * This method can be used to add a series of modules
     * 
     * @access public
     * @param Array $modules
     * @throws Bwork_Module_Exception
     * @return void
     */
    public function addModules(array $modules)
    {
        if(is_array($modules) === false) {
            throw new Bwork_Module_Exception('Added modules are not in the correct format');
        }

        foreach ($modules as $module) {
            $this->addModule($module);
        }
    }

    /**
     * This method can be used to add a single module
     * 
     * @access public
     * @param String $moduleName
     * @throws Bwork_Module_Exception
     * @return Bwork_Module_Manager
     */
    public function addModule($moduleName)
    {
        if(in_array($moduleName, $this->modules) === true) {
            throw new Bwork_Module_Exception(sprintf('Module %s is already loaded.', $moduleName));
        }

        $this->modules[] = strtolower($moduleName);

        return $this;   
    }
    
    /**
     * This method can be used to check if a module had yet been initialized
     * 
     * @access public
     * @param string $moduleName
     * @return boolean
     */
    public function moduleExists($moduleName)
    {
        return in_array(strtolower($moduleName), $this->modules);
    }

    /**
     * This method is used to retrieved initialized modules
     * 
     * @access public
     * @return array $modules
     */
    public function getModules() {
        return $this->modules;
    }

    /**
     * This will check the module files are ready and attempts to run the bootstrap
     * 
     * @access public
     * @param String $moduleName
     * @throws Bwork_Module_Exception
     * @return void
     */
    public function initialize($moduleName)
    {
        $config     = Bwork_Core_Registry::GetInstance()->getResource('Bwork_Config_ConfigHandler');
        $modulePath = $config->get('module_path');

        if(is_dir($modulePath.strtolower($moduleName)) === false) {
            throw new Bwork_Module_Exception(sprintf('The directory for module [%s] cannot be found.', $moduleName));
        }

        $bootstrapFileName  = strtolower($moduleName).'bootstrap.php';
        $bootstrapClassName = ucfirst($moduleName).'Bootstrap';
        $bootstrapFile      = $modulePath.$moduleName.DIRECTORY_SEPARATOR.$bootstrapFileName;

        $configPath     = $modulePath.$moduleName.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR;
        $configFilename = 'config.php';
        $configFile     = $configPath.$configFilename;

        if(file_exists($configFile) === false) {
            throw new Bwork_Module_Exception(sprintf('Config file [%s] was not found for module [%s]', $configFilename, $moduleName));
        }

        $config->loadFile($configFile);

        if(Bwork_Loader_ApplicationAutoloader::fileExists($bootstrapFile) === true) {
            require_once $bootstrapFile;

            $reflectionClass = new ReflectionClass($bootstrapClassName);
            $reflectionClass->newInstance();
        }

    }

}