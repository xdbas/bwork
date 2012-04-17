<?php 

interface Bwork_config_IConfighandler {
    
	public function loadFile($file);
        public function loadArray(array $data);
	public function get($key);
        
}