<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Http
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Request
 *
 * This class holds and handles the URI params
 *
 * @package Bwork
 * @subpackage Bwork_Http
 * @version v 0.2
 */
class Bwork_Http_Request
{
    
    /**
     * Will hold the current URI in string format
     *
     * @var string $uri
     * @access protected
     */
    protected $uri;
    
    /**
     * This wil hold the current URI params in array format
     *
     * @var array $params
     * @access protected
     */
    protected $params;

    /**
     * This will hold the sub url of the framework.
     *
     * @var string $defaultBaseUri
     * @access protected
     */
    protected $defaultBaseUri;

    /**
     * The construction method will handle the current URI and add the string
     * format to self::$uri and explode on a '/' and will add the params to
     * self::$params
     *
     * @access public
     * @return Bwork_Http_Request
     */
    public function __construct()
    {
        $url = isset($_GET['url']) ? trim($_GET['url']) : '';

        $this->uri = substr($url, -1) == '/'? substr($url, 0 , -1) : $url;
        if(strpos($this->uri, '/') !== false) {
            $this->params = explode('/', $this->uri);
        } 
        else {
            if($this->uri != '') {
                $this->params[] = $this->uri;
                return;
            }
            $this->params = array();
        }
    }

    /**
     * This function can be used to create URLs from URIs additionally it can be
     * set to use https prefix
     *
     * @param String $uri
     * @param Boolean $ssl
     * @access public
     * @return String generated Url
     */
    public function create($uri = null, $ssl = false)
    {
        if(empty($this->defaultBaseUri)) {
            $this->defaultBaseUri = Bwork_Core_Registry::getInstance()->getResource('Bwork_Config_Confighandler')->get('sub_url');
        }

        return ($ssl === true? 'https://' . $_SERVER['SERVER_NAME']:'').$this->defaultBaseUri.($uri !== null? $uri:'');
    }

    /**
     * This method is used to retrieve all params
     * 
     * @param String $param
     * @return array Bwork_Http_Request::Params
     */
    public function getParams($param = null)
    {
        if($param !== null) {
            return $this->getParam($param);
        }
        
        return $this->params;
    }

    /**
     * This method is used to retrieve a param
     *
     * @access public
     * @param string $param
     * @param string $default
     * @throws Bwork_Http_Exception
     * @return string
     */
    public function getParam($param, $default = '')
    {
        if(array_key_exists($param, $this->params) === false) {
            if(isset($default)
                || $default === null) {
                return $default;
            }
            throw new Bwork_Http_Exception(sprintf('Param: %s was undefined in URI Params.', $param));
        }
        
        return $this->params[$param];
    }
    
    /**
     * This method is used to retrieve all args in associative format
     *
     * @access public
     * @return array
     */
    public function getArgs()
    {
       $args = array();

       if(isset($this->params) && is_array($this->params)) {
           for($i = 0; $i < count($this->params); $i += 2) {
               $key     = $this->params[$i];
               $value   = isset($this->params[$i + 1]) ? $this->params[$i + 1] : '';

               $args[$key] = $value;
           }
       }

       return $args;
    }

    /**
     * This method is used to retrieve an argument
     *
     * @param string $key
     * @param string $default
     * @throws Bwork_Http_Exception
     * @access public
     * @return string
     */
    public function getArg($key, $default = '')
    {
        $args = $this->getArgs();
        if(count($args) == 0) {
            if(isset($default)
                || $default === null) {
                return $default;
            }
            throw new Bwork_Http_Exception('No arguments found in Http URI.');
        }
        
        if(isset($args[$key]) === false) {
            if(isset($default)
                || $default === null) {
                return $default;
            }
            throw new Bwork_Http_Exception(sprintf('Arg: %s was undefined in URI Args.', $key));
        }

        return $args[$key];
    }
    
    /**
     * Used to retrieve value of params
     *
     * @access public
     * @return int Counted parameters
     */
    public function countParams()
    {
        return count($this->params);
    }
    
    /**
     * This method is used to retrieve post data
     *
     * @access public
     * @param string $key
     * @return mixed
     */
    public function post($key = null)
    {
        if($key === null) {
            return $_POST;
        }
        
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }

    /**
     * The method is used to retrieve get data
     *
     * @access public
     * @param string $key
     * @return mixed
     */
    public function get($key = null)
    {
        if($key === null) {
            return $_GET;
        }

        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    /**
     * This method is used to get raw post data
     *
     * @access public
     * @return mixed
     */
    public function rawPost()
    {
        return file_get_contents('php://input');
    }
    
    /**
     * Used to retrieve the url as a string
     *
     * @access public
     * @return string Bwork_Http_Request::Params
     */
    public function __toString()
    {
        return implode('/', $this->params);
    }
    
}