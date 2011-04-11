<?php

error_reporting(E_ALL ^ E_NOTICE);
define('Obsedb_LOADED',true);

include "global.php";
$cp->header();
require_once("$_REQUEST[load]");

$cp->footer();

?>