<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// spl_autoload_extensions('.php'); // comma-separated list
// spl_autoload_register();

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/constants.php';

$controller = null;
$action = null;
$params = null;

if (!empty($_GET['c'])) {
    $controllerName = filter_var(trim(ucfirst($_GET['c'])), FILTER_SANITIZE_STRING);

    if (!class_exists('App\\Controllers\\' . $controllerName)) {
        throw new \Exception('Controller class App\\Controllers\\' . $controllerName . ' not found');
    }
    
    $controller = 'App\\Controllers\\' . $controllerName;
} else {
    $controller = 'App\\Controllers\\ToDoList';
}

$action = (!empty($_GET['a']) ? filter_var(trim($_GET['a']), FILTER_SANITIZE_STRING) : 'index');

if ($action) {
    $controllerObj = new $controller;

    if (!method_exists($controllerObj, $action)) {
        throw new \Exception('Method ' . $action . ' in controller ' . $controller . ' does not exist');
    }
} else {
    throw new \Exception('Invalid action');
}

if (!empty($_GET['p'])) {
    $params = $_GET['p'];

    if (!is_array($params)) {
        throw new \Exception('Invalid params');
    }

    foreach($params as $k => $v) {
        $params[$k] = filter_var(trim($v), FILTER_SANITIZE_STRING);
    }

    $controllerObj->$action($params);
} else {
    $controllerObj->$action();
}
