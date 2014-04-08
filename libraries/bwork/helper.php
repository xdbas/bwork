<?php

class Bwork_Helper
{
    private static $encoding = 'UTF-8';

    public static function arrayMapRecursive(callable $callback, array $array, $onKeys = false)
    {
        $temp = [];
        foreach ($array as $key => $value) {
            $temp[($onKeys
                ? call_user_func($callback, $key)
                : $key)] = (is_array($value)
                    ? static::arrayMapRecursive($callback, $value, $onKeys)
                    : call_user_func($callback, $value));
        }

        return $temp;
    }

    public static function htmlspecialchars($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, static::encoding(), false);
    }

    public static function htmlspecialcharsArray(array $array, $onKeys = false)
    {
        return static::arrayMapRecursive(array('Bwork_Helper', 'htmlspecialchars'), $array, $onKeys);
    }

    public static function htmlentities($string)
    {
        return htmlentities($string, ENT_QUOTES, static::encoding(), false);
    }

    public static function htmlentitiesArray(array $array, $onKeys = false)
    {
        return static::arrayMapRecursive(array('Bwork_Helper', 'htmlentities'), $array, $onKeys);
    }

    public static function fileExists($file)
    {
        if ($file == ''
            || is_string($file) === false
        ) {
            return false;
        }

        return file_exists($file)
        && is_file($file)
        && is_readable($file);
    }

    public static function encoding()
    {
        return static::$encoding;
    }
}