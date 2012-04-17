<?php
/**
 * Omega Framework
 *
 * @package Omega
 * @subpackage Omega_Validation
 * @author Jorik Zweers <jorikzweers[at]gmail.com>
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Omega Framework v 0.3
 */

/**
 * This is an interface for all form validation classes
 *
 * @package Omega
 * @subpackage Omega_Validation
 * @version v 0.1
 */
interface Bwork_Validation_Interface {
    /**
     * This method is used to add an input to be checked
     *
     * @param string $key
     * @param string $label
     * @param array $validators
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
