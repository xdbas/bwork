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
 * $validator->add("password", "User Password", array(
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
    implements Bwork_Validation_Interface {

    const POST  = 0;
    const GET   = 1;

    /**
     * Type: POST | GET
     *
     * @var int
     */
    private $form_method = self::POST;

    /**
     * Added inputs to validate
     *
     * @var aray
     */
    private $data = array();

    /**
     * Stores all errors
     *
     * @var array
     */
    private $errors = array();

    /**
     * Stores all messages
     *
     * @var array
     */
    private $messages = array();

    /**
     * This method is used to set the current form method
     *
     * @param int $type
     */
    public function setFormMethod($form_method) {
        $this->form_method = $form_method;
    }

    /**
     * This method is used to add an input to be checked
     *
     * @param string $key
     * @param string $label
     * @param array $validators
     */
    public function add($key, $label, array $validators) {
        if($this->form_method == self::POST) {
            $data = isset($_POST[$key]) ? $_POST[$key] : null;
        } else {
            $data = isset($_GET[$key]) ? $_GET[$key] : null;
        }

        $this->data[] = array
            "key"        => $key,
            "data"       => $data,
            "name"       => $label,
            "validators" => $validators
        );
    }
    
    /**
     * This method is used to check an raw string
     *
     * @param string $key
     * @param string $label
     * @param array $validators
     */
    public function addString($data, $label, array $validators) {
        $this->data[] = array(
            "key"        => $label,
            "data"       => $data,
            "name"       => $label,
            "validators" => $validators
        );
    }
    /**
     * This method is used to validate all inputs
     *
     * @return boolean
     */
    public function validate() {
        foreach($this->data as $input) {
            
            foreach($input["validators"] as $validator) {
                $class_name = get_class($validator);
                $key        = substr($class_name, strrpos($class_name, "_") + 1);
                
                if(array_key_exists($key, $this->messages)) {
                    $validator->setMessage($this->messages[$key]);
                }

                $validator->setInput($input["data"], $input["name"]);
                
                if($validator->execute() == false) {
                    $this->errors[$input["key"]] = $validator->getMessage();
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
    public function getErrorCount() {
        return count($this->errors);
    }

    /**
     * This method is used to retrieve all errors
     *
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * This method is used to set global custom messages
     *
     * @param array $message_array
     */
    public function setMessages(array $message_array) {
        
        if(is_array($message_array) == false) {
            throw new Bwork_Exception_Validation(sprintf("%s should be in array format.", $message_array));
        }
        
        $this->messages = $message_array;
    }
    
}