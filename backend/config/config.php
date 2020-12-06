<?php

//Note: This file should be included first in every php page.
error_reporting(E_ALL);
ini_set('display_errors', 'On');
define('BASE_PATH', dirname(dirname(__FILE__)));
define('APP_FOLDER', 'findme');
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));
define("ADMIN_EMAIL", 'admin@findme.ru');
define("ADMIN_PASSWORD", 'admin123');

require_once BASE_PATH . '/lib/MysqliDb/MysqliDb.php';
require_once BASE_PATH . '/helpers/helpers.php';

/*
|--------------------------------------------------------------------------
| DATABASE CONFIGURATION
|--------------------------------------------------------------------------
 */

define('DB_HOST', "localhost");
define('DB_USER', "root");
define('DB_PASSWORD', "");
define('DB_NAME', "hackathon");
// define('DB_HOST', "193.19.118.233");
// define('DB_USER', "admin_default");
// define('DB_PASSWORD', "Ezakanami160798");
// define('DB_NAME', "admin_partnersystem");

/**
 * Get instance of DB object
 */
function getDbInstance() {
	return new MysqliDb(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}