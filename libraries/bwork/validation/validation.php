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
 * This is an interface for all form validation classes
 *
 * @package Bwork
 * @subpackage Bwork_Validation
 * @version v 0.1
 */
interface Bwork_Validation_Validation
{
    /**
     * This method is used to add an input to be checked
     *
     * @param string $key
     * @param string $label
     * @param array $validators
     * @return self
     */
    public function add($key, $label, array $validators);

    /**
     * This method is used to validate all inputs
     *
     * @return boolean
     */
    public function validate();

    /**
     * This method is used to set global custom messages
     *
     * @param array $message_array
     */
    public function setMessages(array $message_array);

}