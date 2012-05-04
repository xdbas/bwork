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
 * IniConfigParser
 *
 * A parser that will return its config vars in array format
 *
 * @final
 * @package Bwork
 * @subpackage Bwork_Config
 * @version v 0.1
 */
final class Bwork_Config_Parser_IniConfigParser 
	implements Bwork_Config_Parser
{

    /**
     * @see Bwork_Config_Parsers_IConfigParser::parse()
     */
    public function parse($file)
    {
        if(file_exists($file) === false 
            || is_file($file) === false
            || is_readable($file) === false) {
            throw new Bwork_Config_Exception(sprintf('%s is not a file or readable.', $file));
        }

        return parse_ini_file($file);
    }

}