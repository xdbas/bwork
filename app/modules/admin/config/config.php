<?php

$config['admin']['default_controller'] = 'test';
$config['admin']['default_action']     = 'index';

$config['admin']['controller_path'] = 'controllers'.DIRECTORY_SEPARATOR;
$config['admin']['model_path']      = 'models'.DIRECTORY_SEPARATOR;
$config['admin']['vo_path']         = $config['admin']['model_path'].'vo'.DIRECTORY_SEPARATOR;
$config['admin']['scripts_path']    = 'view'.DIRECTORY_SEPARATOR.'scripts'.DIRECTORY_SEPARATOR;
$config['admin']['layouts_path']    = 'view'.DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR;