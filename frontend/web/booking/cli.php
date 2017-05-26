<?php
define('SOR_APP_ENV', 'cli');
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'bootstrap.php';
SORApp\Components\App::getInstance()->run();
