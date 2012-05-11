<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Config
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * @package Bwork
 * @subpackage Bwork_Config
 * @version v 0.1
 */
interface Bwork_Config_Parser
{
    
     /**
     * Will parse the selected file and return its data in array format
      *
     * @param string $file
     * @return array
     */
    public function parse($file);
}