<?php
session_start();
error_reporting(E_ALL);

define("BASE", realpath(".." . DIRECTORY_SEPARATOR . ".."));
define("APP", BASE . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);
define("LIBS", BASE . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR); 


require_once LIBS.'bwork/application.php';
Bwork_Application::_initAutoloader();
Bwork_Application::_initBootstrap();
Bwork_Application::Run();