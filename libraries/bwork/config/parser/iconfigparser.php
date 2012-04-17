<?php
interface Bwork_Config_Parser_IConfigParser {
    
     /**
     * Will parse the selected file and return it's data in array format
     * @param string $file
     * @return array
     */
    public function parse($file);
}