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
 * This class is used to handle thrown exception, the method handleException is the main function
 * and is called when an exception has been thrown
 *
 * @package Bwork
 * @subpackage Bwork_Exception
 * @version v 0.2
 */
class Bwork_Exception_Handler
{

    public static $errorCodes = array(
        1 => 'E_ERROR',
        2 => 'E_WARNING',
        4 => 'E_PARSE',
        8 => 'E_NOTICE',
        256 => 'E_USER_ERROR',
        512 => 'E_USER_WARNING',
        1024 => 'E_USER_NOTICE',
        16348 => 'E_USER_DEPRECATED',
    );

    public static function errorCode($code)
    {
        return (array_key_exists($code, static::$errorCodes))
            ? static::$errorCodes[$code]
            : $code;
    }

    /**
     * This method is called when an exception has been thrown
     *
     * @static
     * @access public
     * @param Exception $exception
     * @param string $file
     * @param int $line
     */
    public static function handleException(Exception $exception, $file = null, $line = null)
    {
        $exceptionMessage = $exception->getMessage();
        $exceptionLine = $line !== null
            ? $line
            : $exception->getLine();
        $exceptionTrace = str_replace(BASE, '', $exception->getTraceAsString());
        $exceptionCode = $exception->getCode();

        $exceptionFile = str_replace(
            BASE,
            '',
            ($file !== null
                ? $file
                : $exception->getFile())
        );

        $message = sprintf(
            '(%s)<strong>%s</strong>: %s <br />File: <strong>%s</strong> (Line: <strong>%s</strong>)<br /><br />%s',
            static::errorCode($exceptionCode),
            get_class($exception),
            $exceptionMessage,
            $exceptionFile,
            $exceptionLine,
            $exceptionTrace
        );

        echo '<pre>' . $message . '</pre>';
    }

    /**
     * This function will turn a normal error into an exception
     *
     * @param $code
     * @param $error
     * @param $file
     * @param $line
     */
    public static function handleNormalError($code, $error, $file, $line)
    {
        if (error_reporting() == 0) {
            return;
        }

        static::handleException(new Exception($error, $code), $file, $line);
    }

    /**
     * This function wil handle the shutdown error and throw an exception for it
     */
    public static function handleShutdown()
    {
        $error = error_get_last();

        if ($error !== null) {
            $message = null;
            $type = null;
            $file = null;
            $line = null;

            extract($error, EXTR_OVERWRITE);
            static::handleException(new Exception($message, $type), $file, $line);
        }
    }

}