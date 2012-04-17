<?php
/**
 * Omega Framework
 *
 * @package Omega
 * @subpackage Omega_Validation_Validator
 * @author Jorik Zweers <jorikzweers[at]gmail.com>
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Omega Framework v 0.3
 */

/**
 * Abstract Validator
 *
 * This is the main class for all validators
 *
 * @package Omega
 * @subpackage Omega_Validation_Validator
 * @version v 0.1
 */
abstract class Bwork_Validation_Validator_AbstractValidator implements Bwork_Validation_Validator_Interface {
    
    /**
     * The input key
     *
     * @var string
     */
    protected $input;

    /**
     * The input name
     *
     * @var string
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
     */
    protected $default_message;

    /**
     * The extra params
     *
     * @var array
     */
    protected $params = array();

    /**
     * Constructor
     *
     * @param string $message
     */
    public function __construct($message = NULL) {
        if($message !== NULL) {
            $this->setMessage($message);
        }
    }

    /**
     * Used to set the input
     *
     * @param string $input
     * @param string $name
     */
    public function setInput($input, $name) {
        $this->input        = $input;
        $this->input_name   = $name;
    }

    /**
     * Used to retrieve the message
     *
     * @return string
     */
    public function getMessage() {
        if(empty($this->message)) {
            return sprintf($this->default_message, $this->input_name);
        }

        for($i = 0; $i < sizeof($this->params); $i++) {
            $key = "{param" . ($i + 1) . "}";
            $this->message = str_replace($key, $this->params[$i], $this->message);
        }

        return sprintf($this->message, $this->input_name);
    }

    /**
     * Used to set the message
     *
     * @param string $message
     */
    public function setMessage($message) {
        $this->message = $message;
    }
}