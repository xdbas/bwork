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
     * @access public
     * @param Exception $exception
     */
    public static function onException(Exception $exception)
    {
        $exceptionMessage = $exception->getMessage();
        $exceptionFile    = str_replace(BASE, '', $exception->getFile());
        $exceptionLine    = $exception->getLine();
        $exceptionTrace   = str_replace(BASE, '', $exception->getTraceAsString());

        $message = sprintf(
            '<strong>%s</strong>: %s <br />File: <strong>%s</strong> (Line: <strong>%s</strong>)<br /><br /> %s',
            get_class($exception),
            $exceptionMessage,
            $exceptionFile,
            $exceptionLine,
            $exceptionTrace
        );

        echo '<pre>'.$message.'</pre>';
    }

}