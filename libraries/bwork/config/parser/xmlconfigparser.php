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
 * XMLConfigParser
 *
 * A parser that will return its config vars in array format
 *
 * @final
 * @package Bwork
 * @subpackage Bwork_Config
 * @version v 0.1
 */
final class Bwork_Config_Parser_XMLConfigParser 
    implements Bwork_Config_Parser_IConfigParser {

    /**
     * @see Bwork_Config_Parsers_IConfigParser::parse()
     */
    public function parse($file) {
        $config = array();

        $xml_reader = new XMLReader();
        $xml_reader->open(APPLICATION_PATH.'config/'.$file);
        
        while ($xml_reader->read()) {
            if ($xml_reader->nodeType == XMLREADER::ELEMENT && $xml_reader->localName != "config") {
                $config[$xml_reader->localName] = $xml_reader->readString();
            }
        }

        return $config;
    }

}