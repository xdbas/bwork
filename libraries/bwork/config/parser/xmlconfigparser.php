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
    implements Bwork_Config_Parser
{

    /**
     * XML parse method
     *
     * @see Bwork_Config_Parsers_IConfigParser::parse()
     * @param string $file
     * @throws Bwork_Config_Exception
     * @return array
     */
    public function parse($file)
    {
        $config = array();

        if(file_exists($file) === false 
            || is_file($file) === false
            || is_readable($file) === false) {
            throw new Bwork_Config_Exception(sprintf('%s is not a file or readable.', $file));
        }

        $xml_reader = new XMLReader();
        $xml_reader->open($file);
        
        while ($xml_reader->read()) {
            if ($xml_reader->nodeType == XMLREADER::ELEMENT 
                && $xml_reader->localName != "config") {
                $config[$xml_reader->localName] = $xml_reader->readString();
            }
        }

        return $config;
    }

}