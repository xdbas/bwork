<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Validation_Validator
 * @author Bas van Manen <basje1[at]gmail.com>
 * @author Jorik Zweers <jorikzweers[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Abstract Validator
 *
 * This is the main class for all validators
 *
 * @package Bwork
 * @subpackage Bwork_Validation
 * @version v 0.1
 */
abstract class Bwork_Validation_AbstractValidator
    implements Bwork_Validation_Validator
{
    
    /**
     * The input key
     *
     * @var string
     * @access protected
     */
    protected $input;

    /**
     * The input name
     *
     * @var string
     * @access protected
     */
    protected $input_name;

    /**
     * The current message
     *
     * @var string
     */
    protected $message;

    /**
     * The default message
     *
     * @var string
     * @access protected
     */
    protected $default_message;

    /**
     * The extra params
     *
     * @var array
     * @access protected
     */
    protected $params = array();

    /**
     * Constructor
     *
     * @param string $message
     */
    public function __construct($message = null)
    {
        if($message !== null) {
            $this->setMessage($message);
        }
    }

    /**
     * Used to set the input
     *
     * @param string $input
     * @param string $name
     * @access public
     */
    public function setInput($input, $name)
    {
        $this->input        = $input;
        $this->input_name   = $name;
    }

    /**
     * Used to retrieve the message
     *
     * @access public
     * @return string
     */
    public function getMessage()
    {
        if(empty($this->message)) {
            return sprintf($this->default_message, $this->input_name);
        }

        for($i = 0; $i < sizeof($this->params); $i++) {
            $key = '{param' . ($i + 1) . '}';
            $this->message = str_replace($key, $this->params[$i], $this->message);
        }

        return sprintf($this->message, $this->input_name);
    }

    /**
     * Used to set the message
     *
     * @access public
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

}