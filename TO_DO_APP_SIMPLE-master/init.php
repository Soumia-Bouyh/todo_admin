<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('APP_LANG','en');

include("lib/db.php");
include("lib/utils.php");
include("lang/".APP_LANG.".php");
include("lib/func.user.php");

//It is very stupid to share passwords within GIT, but for demostration, we will close our eyes on this principle.
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'db_todo+';

$db = new db($dbhost, $dbuser, $dbpass, $dbname);

$vars=get_input_vars();

$appuser=user_get_logged_user();
?>