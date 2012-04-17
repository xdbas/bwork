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
 * This validator checks the input is set
 *
 * @package Omega
 * @subpackage Omega_Validation_Validator
 * @version v 0.1
 */
final class Bwork_Validation_Validator_Required extends Bwork_Validation_Validator_AbstractValidator {
    
    /**
     * The default message
     *
     * @var string
     */
    protected $default_message = "[%s] is required.";

    /**
     * This method is used to execute the validator
     *
     * @return boolean
     */
    public function execute() {
        return mb_strlen((string)$this->input) > 0;
    }
}