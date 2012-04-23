<?php 
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Config
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Config
 *
 * This class stores all the config data.
 *
 * @package Bwork
 * @subpackage Bwork_Config
 * @version v 0.2
 * @final
 */
final class Bwork_Config_Confighandler implements Bwork_config_Handler
{
    
    /**
     * This will hold all the config settings set throughout the project
     * @var array $settings
     * @access private
     */
    private $settings = array();
    
    /**
     * This will hold all config parsers objects
     * @var array $parsers
     * @access private
     */
    private $parsers = array();

    /**
     * @see Bwork_Config_Handler::loadFile()
     */
    public function loadFile($file)
    {
        if(is_string($file) === true) {
            $file_extension = substr($file, strrpos($file, '.') + 1);

            if(array_key_exists($file_extension, $this->parsers)) {
                $data = $this->parsers[$file_extension]->parse($file);
            } 
            else {
                throw new Bwork_Exception_ConfigException(sprintf('File type %s is not supported.', $file_extension));
            }
        }
        
        $this->loadArray($data);
        
        return $this;
    }
    
    /**
     * @see Bwork_Config_Handler::loadArray()
     */
    public function loadArray(array $data)
    {
        if(is_array($data) == false) {
            throw new Bwork_Exception_ConfigException('Input data should be an array.');
        }
   
        $this->settings = array_merge($this->settings, $data);
    }

    /**
     * Will attempt to add the parser to the $parsers
     * @param string $ext
     * @param Bwork_config_Handler $parser
     * @access public
     * @return Bwork_Config_Confighandler 
     */
    public function setParser($ext, Bwork_config_Handler $parser)
    {
        if(is_object($parser) === false) {
            throw new Bwork_Exception_ConfigException('Parser is not an object.');
        }

        if($parser instanceof Bwork_config_Handler === false) {
            throw new Bwork_Exception_ConfigException('Parser is not an instance of IConfigParser.');
        }

        $this->parsers[$ext] = $parser;
        
        return $this;
    }

    /**
     * Magic method __set
     * @see Bwork_Config_Confighandler::set()
     * @param string $key
     * @param string $value
     * @access public
     * @return Bwork_Config_Confighandler
     */
    public function __set($key, $value)
    {
        return $this->set($key, $value);
    }

    /**
     * Will add the key-value arguments to $settings
     * @param string $key
     * @param string $value
     * @access public
     * @return Bwork_Config_Confighandler
     */
    public function set($key, $value)
    {
        if($this->exists($key) === true){
            throw new Bwork_Exception_ConfigException('This setting is already set.');
        }

        $this->settings[$key] = $value;
        
        return $this;
    }
    
    /**
     * Magic methods __get
     * @see Bwork_Config_Confighandler::get()
     * @param string $key
     * @return void 
     */
    public function __get($key)
    {
        $this->get($key);
    }

    /**
     * @see Bwork_Config_Handler::get()
     */
    public function get($key)
    {
        if($this->exists($key) === false) {
            throw new Bwork_Exception_ConfigException(sprintf('%s: Is not found in Bwork_Config_Confighandler::Settings', $key));
        }

        return $this->settings[$key];
    }
    
    /**
     * Called when isset(Bwork_Config_Confighandler) and will return boolean if
     * isset
     * @param string $key
     * @return string 
     */
    public function __isset($key)
    {
        return isset($this->settings[$key]);
    }

    /**
     * This will check if a key is set in the settings array
     * @param string $key
     * @access public
     * @return void 
     */
    public function exists($key)
    {
        return array_key_exists($key, $this->settings);
    }
    
}