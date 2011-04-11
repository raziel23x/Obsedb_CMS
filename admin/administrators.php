<?php
error_reporting(E_ALL ^ E_NOTICE);
include "global.php";
include "../sources/adminAdministratorsClass.php";

$module = new Module;
$module->initForm();

?>