<?php

return array(
    /**
     * Default controller that is used when none are specified
     */
    'default_controller'      => 'home',

    /**
     * The default action that will be invoked when none are found
     */
    'default_action'          => 'index',


    /**
     * Default view extensions that are allowed for view templates
     */
    'default_view_extensions' => array(
        'php',
        'html',
        'xml'
    ),

    /**
     * The default view extension for your templates
     */
    'default_view_extension'  => 'php',

    /**
     * Paths to different folders
     */
    'controller_path'         => APPLICATION_PATH.'controllers'.DIRECTORY_SEPARATOR,
    'model_path'              => APPLICATION_PATH.'models'.DIRECTORY_SEPARATOR,
    'vo_path'                 => APPLICATION_PATH.'models'.DIRECTORY_SEPARATOR.'vo'.DIRECTORY_SEPARATOR,
    'scripts_path'            => APPLICATION_PATH.'view'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR,
    'layouts_path'            => APPLICATION_PATH.'view'.DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR,
    'module_path'             => APPLICATION_PATH.'modules'.DIRECTORY_SEPARATOR,

    /**
     * Your sub indentifying url e.g /website/
     * This is needed to create urls from the beginning of your path.
     */
    'sub_url'                 => '/',

    /**
     * This will specify if you are on a development environment or production
     * Some error handling will behave differently.
     */
    'dev_env'                 => false,

    /**
     * The 404 page settings
     */
    '404_page'           => array(
        'controller' => 'home',
        'action'     => 'display404',
        'module'     => null
    ),

    /**
     * The application encoding sent through the HTTP Response header
     */
    'encoding' => 'UTF-8',

    /**
     * The default database settings used in the data objects
     */
    'database' => array(
        'host'        => '127.0.0.1',
        'dbname'      => 'bwork',
        'username'    => 'root',
        'password'    => 'root',
        'port'        => '3306',
        'charset'     => 'utf8',
    ),
);