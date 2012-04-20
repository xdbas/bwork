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
 * MinLength
 *
 * This validator checks if the length of a string is long enough.
 *
 * @package Bwork
 * @subpackage Bwork_Validation_Validator
 * @version v 0.1
 */
final class Bwork_Validation_Validator_MinLength 
    extends Bwork_Validation_Validator_AbstractValidator {
    /**
     * The minimum length
     *
     * @var int
     */
    private $min_length;

    /**
     * Constructor
     *
     * @param int $length
     * @param string $message
     */
    public function __construct($length, $message = NULL) {
        $this->default_message  = '[%s] should have atleast ' . $length . ' characters';
        $this->min_length       = $length;
        $this->params[]         = $length;

        parent::__construct($message);
    }

    /**
     * This method is used to execute the validator
     *
     * @return boolean
     */
    public function execute() {
        return (empty($this->input) || mb_strlen($this->input) >= $this->min_length);
    }
    
 }