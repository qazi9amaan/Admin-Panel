<?php
session_start(); // ready to go!
$allowed_pincodes=Array(
190001,190002,191101,190010,190001,190001,190002,190002,190003,190003,190003,190004,190005,190006,190006,190007,190007,190008,190008,190009,190009,190010,190010,190011,190011,190012,190015,190017,190018,190018,190019,190019,191101,191101,191101,191111,191111,191111,191113,191113,190001,191121,190002,190001,190014,190002,190003,190003,190002,190006,190015,190002,190001,190001,190007,190001,190003,191202,190011,190020,190001,	190019,191101,191123,190009,	190001,	190002,191201,191202,191131,191202,	190002,190008,191202,190010,191131,190006,	190003,190003,191103,191202,190011,	190001,191101,191202,190003,190001,190009,190011,190017,192121,191101,191101,190017,191131,190003,190008,190009,	191202,190001,190002,190002,191131,190001,191131,191131,191203,190001,191131,191202,191102,190012,190006,191101,
);
//Note: This file should be included first in every php page.
error_reporting(E_ALL);
ini_set('display_errors', 'Off');
// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 3600);

// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600);

define('BASE_PATH', dirname(dirname(__FILE__)));
define("PARENT",     "/var/www/html");
define('APP_FOLDER', 'simpleadmin');
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));

require_once BASE_PATH . '/lib/MysqliDb/MysqliDb.php';
require_once BASE_PATH . '/helpers/helpers.php';




/*
|--------------------------------------------------------------------------
| DATABASE CONFIGURATION
|--------------------------------------------------------------------------
 */

define('DB_HOST', "localhost");
define('DB_USER', "root");
define('DB_PASSWORD', "root");
define('DB_NAME', "corephpadmin");

/**
 * Get instance of DB object
 */
function getDbInstance() {
	return new MysqliDb(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$sql = "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
mysqli_query($conn, $sql);

