<?php
declare(strict_types=1);

session_start();
error_reporting(E_ALL ^ E_NOTICE);

date_default_timezone_set('Europe/Belgrade');
$GLOBALS['my_config'] = array(
    'mysql' => array(
        'host' => 'localhost',
        'port' => '3306',
        'username' => 'root',
        'password' => '',
        'db' => 'news'
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);

spl_autoload_register(
    function ($class) {
        include_once 'classes/' . $class . '.php';
    }
);
require_once 'functions/sanitize.php';
