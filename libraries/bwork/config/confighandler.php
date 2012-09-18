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
 * @version v 0.3
 * @final
 */
final class Bwork_Config_Confighandler 
    extends ArrayObject 
    implements Bwork_config_Handler
{
    
    /**
     * This will hold all config parsers objects
     *
     * @var array $parsers
     * @access private
     */
    private $parsers = array();

    /**
     * Load file method
     *
     * @see Bwork_Config_Handler::loadFile()
     * @param string $file
     * @throws Bwork_Config_Exception
     * @return Bwork_Config_Confighandler
     */
    public function loadFile($file)
    {
        if(is_string($file) === true) {
            $path_info = pathinfo($file);
            $file_extension = $path_info['extension'];

            if(array_key_exists($file_extension, $this->parsers)) {
                $data = $this->parsers[$file_extension]->parse($file);
            } 
            else {
                throw new Bwork_Config_Exception(sprintf('File type %s is not supported.', $file_extension));
            }
        }
        
        $this->loadArray($data);
        
        return $this;
    }

    /**
     * Load array method
     *
     * @see Bwork_Config_Handler::loadArray()
     * @param array $data
     * @throws Bwork_Config_Exception
     * @return void
     */
    public function loadArray(array $data)
    {
        if(is_array($data) == false
            && $data instanceof Travsersable == false) {
            throw new Bwork_Config_Exception('Input data should be an array.');
        }
        
        foreach($data as $item => $value) {
            $this->offsetSet($item, $value);
        }
    }

    /**
     * Will attempt to add the parser to the $parsers
     *
     * @access public
     * @param string $ext
     * @param Bwork_config_Parser $parser
     * @throws Bwork_Config_Exception
     * @return Bwork_Config_Confighandler
     */
    public function setParser($ext, Bwork_Config_Parser $parser)
    {
        if(is_object($parser) === false) {
            throw new Bwork_Config_Exception(sprintf('Parser %s is not an object.', get_class($parser)));
        }

        if($parser instanceof Bwork_Config_Parser === false) {
            throw new Bwork_Config_Exception(sprintf('Parser %s is not an instance of Bwork_Config_Parser.', get_class($parser)));
        }

        $this->parsers[$ext] = $parser;
        
        return $this;
    }

    /**
     * Magic method __set
     *
     * @see Bwork_Config_Confighandler::set()
     * @param string $key
     * @param mixed $value
     * @return Bwork_Config_Confighandler
     */
    public function __set($key, $value)
    {
        return $this->set($key, $value);
    }

    /**
     * Will add the key-value arguments to $settings
     *
     * @param string $key
     * @param string $value
     * @access public
     * @throws Bwork_Config_Exception
     * @return Bwork_Config_Confighandler
     */
    public function set($key, $value)
    {
        if($this->offsetExists($key) === true){
            throw new Bwork_Config_Exception(sprintf('Setting %s is already set.', $key));
        }

        $this->offsetSet($key, $value);
        
        return $this;
    }

    /**
     * Magic methods __get
     *
     * @see Bwork_Config_Handler::get()
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        $this->get($key);
    }

    /**
     * This method will return a specific setting
     *
     * @see Bwork_Config_Handler::get()
     * @param string $key
     * @throws Bwork_Config_Exception
     * @return mixed
     */
    public function get($key)
    {
        if($this->offsetExists($key) === false) {
            throw new Bwork_Config_Exception(sprintf('%s: Is not found in Bwork_Config_Confighandler::Settings', $key));
        }

        return $this->offsetGet($key);
    }
    
    /**
     * This will check if a key is set in the storage
     *
     * @param string $key
     * @access public
     * @return boolean
     */
    public function exists($key)
    {
        return $this->offsetExists($key);
    }
    
}