<?php
interface Bwork_View_IView {
    
    public function assign($key, $value);
    
    public function fetch();
    
    public function display();
    
}