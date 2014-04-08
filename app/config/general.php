<?php

return array(
    'default_controller'      => 'home',
    'default_action'          => 'index',

    'default_view_extensions' => array(
        'php',
        'html',
        'xml'
    ),
    'default_view_extension'  => 'php',

    'controller_path'         => APPLICATION_PATH.'controllers'.DIRECTORY_SEPARATOR,
    'model_path'              => APPLICATION_PATH.'models'.DIRECTORY_SEPARATOR,
    'vo_path'                 => APPLICATION_PATH.'models'.DIRECTORY_SEPARATOR.'vo'.DIRECTORY_SEPARATOR,
    'scripts_path'            => APPLICATION_PATH.'view'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR,
    'layouts_path'            => APPLICATION_PATH.'view'.DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR,
    'module_path'             => APPLICATION_PATH.'modules'.DIRECTORY_SEPARATOR,

    'sub_url'                 => '/',

    'dev_env'                 => false,

    '404_page'           => array(
        'controller' => 'home',
        'action'     => 'display404',
        'module'     => null
    ),

    'database' => array(
        'host'        => '127.0.0.1',
        'dbname'      => 'bwork',
        'username'    => 'root',
        'password'    => 'root',
        'port'        => '3306',
    ),
);