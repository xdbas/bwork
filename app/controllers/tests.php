<?php

class TestsController extends Bwork_Controller_action {
    
    public function __construct() {
        parent::__construct();
        //print_r($this);
    }
    
    public function indexAction() {
        $layout = new Bwork_View_Default();
        $layout->assign('testvar', 'testvalue');
        
        $testModel = new TestModel();



        return $layout;

    }
    
    public function testAction() {
        
        $testVars = array(
            'hello',
            '1',
            '0',
            '',
            null,
            'a',
            'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        );
        
        $validator = new Bwork_Validation_FormValidation();
        
        $i = 0;
        foreach($testVars as $var) {
            
            $validator->addString($var, $i, array(
                new Bwork_Validation_Validator_Required()
                ));
            
            $i++;
        }
        
        if($validator->validate()) {
            echo 'Ja';
        }
        else {
            print_r($validator->getErrors());
        }
        
    }
    
}