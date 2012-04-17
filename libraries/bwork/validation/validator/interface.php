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
 * Validator
 *
 * This is the interface for all validators
 *
 * @package Omega
 * @subpackage Omega_Validation_Validator
 * @version v 0.1
 */
interface Bwork_Validation_Validator_Interface {
    
    public function setInput($input, $input_name);
    
    public function getMessage();
    
    public function execute();
    
}
