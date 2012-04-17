<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Config
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
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
final class Bwork_Config_Parser_IniConfigParser implements Bwork_Config_Parser_IConfigParser {

    /**
     * @see Bwork_Config_Parsers_IConfigParser::parse()
     */
    public function parse($file) {
        $config = array();
        $config = parse_ini_file(APP."config/".$file);

        return $config;
    }

}