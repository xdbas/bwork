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
 * MaxLength
 *
 * This validator checks if a string exceeds the maximum length
 *
 * @package Omega
 * @subpackage Omega_Validation_Validator
 * @version v 0.1
 */
final class Bwork_Validation_Validator_MaxLenght extends Bwork_Validation_Validator_AbstractValidator {
    
    private $max_length;

    /**
     * Constructor
     *
     * @param int $length
     * @param string $message
     */
    public function __construct($length, $message = NULL) {
        $this->default_message  = "[%s] exceeded the maximum length of " . $length . ".";
        $this->max_length       = $length;
        $this->params[]         = $length;

        parent::__construct($message);
    }

    /**
     * This method is used to execute the validator
     *
     * @return boolean
     */
    public function execute() {
        return (empty($this->input) || mb_strlen($this->input) < $this->max_length);
    }
    
}