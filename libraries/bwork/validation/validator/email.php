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
 * Email Validator
 *
 * This is used to validate is an email is right
 *
 * @package Bwork
 * @subpackage Bwork_Validation_Validator
 * @version v 0.1
 */
final class Bwork_Validation_Validator_Email 
    extends Bwork_Validation_AbstractValidator
{

    /**
     * The default message
     *
     * @var string
     * @access protected
     * @override
     */
    protected $default_message = '[%s] should be a valid email address.';


    /**
     * Constructor
     *
     * @param string $message
     * @return Bwork_Validation_Validator_Email
     */
    public function __construct($message = null)
    {
        parent::__construct($message);
    }

    /**
     * This method is used to execute the validator
     *
     * @return boolean
     */
    public function execute() {
        return filter_var($this->input, FILTER_VALIDATE_EMAIL);
    }
}
