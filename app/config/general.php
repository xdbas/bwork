<?php
//$config['subdirectory_url'] = DIRECTORY_SEPARATOR.'bwork'.DIRECTORY_SEPARATOR;
//$config['default_helper_path'] = LIBS.'bwork'.DIRECTORY_SEPARATOR.'helper'.DIRECTORY_SEPARATOR;

$config['default_controller'] = 'test';
$config['default_action'] = 'index';

$config['default_view_extensions'] = array('php', 'phtml' 'html', 'xml');
$config['default_view_extension'] = '.php';

$config['controller_path'] = APPLICATION_PATH.'controllers'.DIRECTORY_SEPARATOR;
$config['scripts_path'] = APPLICATION_PATH.'view'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR;
$config['layouts_path'] = APPLICATION_PATH.'view'.DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR;

$config['sub_url'] = '/';

$config['database']['host'] = '127.0.0.1';
$config['database']['dbname'] = 'bwork';
$config['database']['username'] = 'root';
$config['database']['password'] = 'root';
$config['database']['port'] = '3306';