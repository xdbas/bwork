<?php

interface Bwork_Layout_ILayout {
    
    public function setLayout($layout);
    
    public function getLayout();
    
    public function setContent($content);
    
    public function getContent();
    
    public function fetch();
}