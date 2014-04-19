<?php
session_start();
error_reporting(-1);

if (defined('DS') === false) {
    define('DS', DIRECTORY_SEPARATOR);
}

chdir(__DIR__);

define('PUBLIC_PATH', realpath('.') . DS);
define('BASE', realpath('..' . DS . '..'));
define('APPLICATION_PATH', BASE . DS . 'app' . DS);
define('LIBRARY_PATH', BASE . DS . 'libraries' . DS);

set_include_path( /*get_include_path() . PATH_SEPARATOR . */
    LIBRARY_PATH
);

require_once 'Bwork/Application.php';
\Bwork\Application::Run();