<?php
class TestController extends Bwork_Controller_Action
{
    
    public function indexAction()
    {
        
        return new Bwork_View_Default();
    }

}