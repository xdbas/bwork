<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Validation
 * @author Bas van Manen <basje1[at]gmail.com>
 * @author Jorik Zweers <jorikzweers[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Validator
 *
 * This is the interface for all validators
 *
 * @package Bwork
 * @subpackage Bwork_Validation
 * @version v 0.1
 */
interface Bwork_Validation_Validator
{

    /**
     * This method is used by the form validator to set the current input values
     *
     * @abstract
     * @param string $input
     * @param string $input_name
     * @return mixed
     */
    public function setInput($input, $input_name);

    /**
     * This method is used to retrieve a message
     *
     * @abstract
     * @return String
     */
    public function getMessage();

    /**
     * This method is used to execute the validator
     *
     * @abstract
     * @return bool
     */
    public function execute();
    
}
