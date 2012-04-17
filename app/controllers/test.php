<?php

class TestController extends Bwork_Controller_Action {
    
    
    public function indexAction() {
        
        $testModel = new TestModel();
        $testModel->test();
        
        return new Bwork_View_Default();
    }
    
    
}
