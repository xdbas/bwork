<?php
$config['subdirectory_url'] = DIRECTORY_SEPARATOR.'bwork'.DIRECTORY_SEPARATOR;

$config['default_controller'] = "test";
$config['default_action'] = "index";

$config['default_view_extensions'] = array("php", "html", "xml");
$config['default_view_extension'] = ".php";

$config['controller_path'] = APP.'controllers'.DIRECTORY_SEPARATOR;
$config['scripts_path'] = APP.'view'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR;
$config['layouts_path'] = APP.'view'.DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR;

$config['default_helper_path'] = LIBS.'bwork'.DIRECTORY_SEPARATOR.'helper'.DIRECTORY_SEPARATOR;

$config['database']['host'] = '127.0.0.1';
$config['database']['dbname'] = 'bwork';
$config['database']['username'] = 'root';
$config['database']['password'] = 'root';
$config['database']['port'] = '3306';
?>
