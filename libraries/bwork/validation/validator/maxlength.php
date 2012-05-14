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
 * MaxLength
 *
 * This validator checks if a string exceeds the maximum length
 *
 * @package Bwork
 * @subpackage Bwork_Validation_Validator
 * @version v 0.1
 */
final class Bwork_Validation_Validator_MaxLength 
    extends Bwork_Validation_AbstractValidator
{

    /**
     * This holds the max length set by the constructor
     *
     * @var int
     * @access private
     */
    private $max_length;

    /**
     * Constructor
     *
     * @param int $length
     * @param string $message
     * @return Bwork_Validation_Validator_MaxLength
     */
    public function __construct($length, $message = null)
    {
        $this->default_message  = '[%s] exceeded the maximum length of ' . $length . '.';
        $this->max_length       = $length;
        $this->params[]         = $length;

        parent::__construct($message);
    }

    /**
     * This method is used to execute the validator
     *
     * @access public
     * @return boolean
     */
    public function execute()
    {
        return (empty($this->input) || mb_strlen($this->input) <= $this->max_length);
    }
    
}