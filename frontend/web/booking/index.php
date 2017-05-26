<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'bootstrap.php';
require_once(dirname(__FILE__) . '/../../../vendor/SORApp/bootstrap.php');

// Run web application
\SORApp\Components\App::getInstance()->run();
//echo \SORApp\Components\App::getInstance()->runController('site', 'module', 'index')->send();
