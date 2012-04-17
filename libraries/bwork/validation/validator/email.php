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
 * Email Validator
 *
 * This is used to validate is an email is right
 *
 * @package Omega
 * @subpackage Omega_Validation_Validator
 * @version v 0.1
 */
final class Bwork_Validation_Validator_Email extends Bwork_Validation_Validator_AbstractValidator {
    /**
     * The default message
     *
     * @var string
     */
    protected $default_message = "[%s] should be a valid emailaddress.";

    /**
     * This method is used to execute the validator
     *
     * @return boolean
     */
    public function execute() {
        return filter_var($this->input, FILTER_VALIDATE_EMAIL);
    }
}
