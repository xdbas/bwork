<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Http
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 */

/**
 * Request
 *
 * This class holds and handles the URI params
 *
 * @package Bwork
 * @subpackage Bwork_Http
 * @version v 0.1
 */
class Bwork_Http_Request {
    
    /**
     * Will hold the current URI in string format
     * @var string $uri
     * @access protected
     */
    protected $uri;
    
    /**
     * This wil hold the current URI params in array format
     * @var array $params
     */
    protected $params;
    
    /**
     * The construction method will handle the current URI and add the string 
     * format to self::$uri and explode on a '/' and will add the params to 
     * self::$params
     * @access public
     * @return void
     */
    public function __construct() {
        $url = isset($_GET['url']) ? trim($_GET['url']) : '';

        $this->uri = substr($url, -1) == "/"? substr($url, 0 , -1) : $url;
        if(strpos($this->uri, "/") !== false) {
            $this->params = explode("/", $this->uri);
                    
        } 
        else {
            if($this->uri != "") {
                $this->params[] = $this->uri;
                return;
            }
            $this->params = array();
        }
    }
    
    /**
     * This method is used to retrieve all params
     * 
     * @param string $param
     * @return array Bwork_Http_Request::Params
     */
    public function getParams($param = null) {
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
     * @return string
     */
    public function getParam($param, $default = "") {
        if(array_key_exists($param, $this->params) === false) {
            if(isset($default) 
                || $default === null) {
                return $default;
            }
            throw new Bwork_Exception_HttpException(sprintf("Param: %s was undifined in URI Params.", $param));
        }
        
        return $this->params[$param];
    }
    
    /**
     * This method is used to retreive all args in associative format
     *
     * @return array
     */
    public function getArgs() {
       $args = array();

       if(isset($this->params) && is_array($this->params)) {
           for($i = 0; $i < count($this->params); $i += 2) {
               $key     = $this->params[$i];
               $value   = isset($this->params[$i + 1]) ? $this->params[$i + 1] : "";

               $args[$key] = $value;
           }
       }

       return $args;
    }
    
    /**
     * This method is used to retrieve an argument
     *
     * @param string $key
     * @return string
     */
    public function getArg($key)
    {
        $args = $this->getArgs();
        if(count($args) == 0) {
            throw new Bwork_Exception_HttpException("No arguments found in Http URI.");
        }
        
        if(isset($args[$key]) === false) {
            throw new Bwork_Exception_HttpException(sprintf("Arg: %s was undefined in URI Args.", $key));
        }

        return $args[$key];
    }
    
    /**
     * Used to retrieve value of params
     * 
     * @return int
     */
    public function countParams() {
        return count($this->params);
    }
    
    /**
     * This method is used to retrieve post data
     *
     * @access public
     * @param string $key
     * @return mixed
     */
    public function post($key = null) {
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
     * @return midex
     */
    public function get($key = null) {
        if($key === null) {
            return $_GET;
        }

        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    /**
     * This method is used to get raw post data
     *
     * @return mixed
     */
    public function rawPost() {
        return file_get_contents("php://input");
    }
    
    /**
     * Used to retrieve the url
     * @return string Bwork_Http_Request::Params
     */
    public function __toString() {
        return implode("/", $this->params);
    }
    
}