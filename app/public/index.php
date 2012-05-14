<?php
session_start();
error_reporting(E_ALL);

define('BASE', realpath('..' . DIRECTORY_SEPARATOR . '..'));
define('APPLICATION_PATH', BASE . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);
define('LIBRARY_PATH', BASE . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR); 

set_include_path(/*get_include_path() . PATH_SEPARATOR . */LIBRARY_PATH);

require_once 'bwork/application.php';
Bwork_Application::Run();