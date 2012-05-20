<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Exception
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Handler
 *
 * This class is used to handle thrown exception, the method onException is the main function
 * and is called when an exception has been thrown
 *
 * @package Bwork
 * @subpackage Bwork_Exception
 * @version v 0.1
 */
class Bwork_Exception_Handler
{

    /**
     * This method is called when an exception has been thrown
     *
     * @static
     * @param Exception $exception
     */
    public static function onException(Exception $exception)
    {

        echo '<pre>';
        print_r($exception);
        echo '</pre>';
    }
}