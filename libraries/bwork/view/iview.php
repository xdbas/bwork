<?php
interface Bwork_View_IView {
    
    public function assign($key, $value = null);
    
    public function fetch();
    
    public function display();
    
}