<?php

error_reporting(E_ALL ^ E_NOTICE);

include "../config.php";
include "../sources/auth/auth.inc.php";
include "../sources/version.inc.php";
include "../sources/db/adodb.inc.php";
include "../sources/adminFunctions.php";
include "../sources/admin_templates/controlpanel.class.php";
include("../language/default/admin_main.php");

$db = NewADOConnection('mysql');
$db->Connect($db_host,$db_user,$db_pass,$db_name);

global $pwzid, $pwzlogin, $version;

if ($_SESSION['pwzid'] == $superadministrator)
{
   define('SUPERADMIN_MODE','1');
}

// Cache configuration data
$spconfig = array();
$Obsedb_configuration = $db->Execute("SELECT Obsedb_configuration.key, Obsedb_configuration.value FROM Obsedb_configuration");
while ($row = $Obsedb_configuration->FetchNextObject())
{
	$spconfig["$row->KEY"] = stripslashes($row->VALUE);
}

$cp = new AdminCP;
$cp->phrase = $cp->getPhrases( 'adminIndex' );
?>