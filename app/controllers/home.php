<?php

class HomeController extends Bwork_Controller_Action {

    public function indexAction() {
        return new Bwork_View_Default();
    }

    public function display404Action()
    {
        $this->layoutEnabled = false;
        $this->getResponse()->setStatus(404);

        return "Page not found";
    }

}