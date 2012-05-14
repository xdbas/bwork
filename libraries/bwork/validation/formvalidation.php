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
 * Form validation 
 *
 * Example:
 * <code>
 * $validator = new Bwork_Validation_FormValidation();
 * $validator->add('password', 'User Password', array(
 *     new Bwork_Validation_Validator_Required(),
 *     new Bwork_Validation_Validator_MinLength(10)
 * ));
 *
 * if($validator->validate()) {
 *     // code ...
 * }
 * </code>
 *
 * @package Bwork
 * @subpackage Bwork_Validation
 * @version v 0.1
 */
class Bwork_Validation_FormValidation 
    implements Bwork_Validation_Validation
{

    const POST  = 0;
    const GET   = 1;

    /**
     * Type: POST | GET
     *
     * @var int
     * @access private
     */
    private $form_method = self::POST;

    /**
     * Added inputs to validate
     *
     * @var array
     * @access private
     */
    private $data = array();

    /**
     * Stores all errors
     *
     * @var array
     * @access private
     */
    private $errors = array();

    /**
     * Stores all messages
     *
     * @var array
     * @access private
     */
    private $messages = array();

    /**
     * This method is used to set the current form method
     *
     * @param int $form_method
     */
    public function setFormMethod($form_method)
    {
        $this->form_method = $form_method;
    }

    /**
     * This method is used to add an input to be checked
     *
     * @param string $key
     * @param string $label
     * @param array $validators
     * @return Bwork_Validation_FormValidation
     */
    public function add($key, $label, array $validators)
    {
        if($this->form_method == self::POST) {
            $data = isset($_POST[$key]) ? $_POST[$key] : null;
        } else {
            $data = isset($_GET[$key]) ? $_GET[$key] : null;
        }

        $this->data[] = array(
            'key'        => $key,
            'data'       => $data,
            'name'       => $label,
            'validators' => $validators
        );

        return $this;
    }

    /**
     * This method is used to check an raw string
     *
     * @param string $data
     * @param string $label
     * @param array $validators
     * @return Bwork_Validation_FormValidation
     */
    public function addString($data, $label, array $validators)
    {
        $this->data[] = array(
            'key'        => $label,
            'data'       => $data,
            'name'       => $label,
            'validators' => $validators
        );

        return $this;
    }
    /**
     * This method is used to validate all inputs
     *
     * @return bool
     */
    public function validate()
    {
        foreach($this->data as $input) {
            
            foreach($input['validators'] as $validator) {
                $class_name = get_class($validator);
                $key        = substr($class_name, strrpos($class_name, '_') + 1);
                
                if(array_key_exists($key, $this->messages)) {
                    $validator->setMessage($this->messages[$key]);
                }

                $validator->setInput($input['data'], $input['name']);
                
                if($validator->execute() == false) {
                    $this->errors[$input['key']] = $validator->getMessage();
                    break;
                }
            }
        }

        return $this->getErrorCount() == 0;
    }

    /**
     * This method is used to retrieve the error count
     *
     * @return int
     */
    public function getErrorCount()
    {
        return count($this->errors);
    }

    /**
     * This method is used to retrieve all errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * This method is used to set global custom messages
     *
     * @param array $message_array
     * @throws Bwork_Validation_Exception
     */
    public function setMessages(array $message_array)
    {
        
        if(is_array($message_array) == false) {
            throw new Bwork_Validation_Exception(sprintf('%s should be in array format.', $message_array));
        }
        
        $this->messages = $message_array;
    }
    
}