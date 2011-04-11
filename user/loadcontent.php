<?php

error_reporting(E_ALL ^ E_NOTICE);

include "../config.php";
include "../sources/auth/auth.inc.php";
include "../sources/db/adodb.inc.php";
include "../sources/user/functions.php";
include "../sources/user_templates/controlpanel.class.php";

$db = NewADOConnection('mysql');
$db->Connect($db_host,$db_user,$db_pass,$db_name);

if (empty($_REQUEST['title']))
{
	$statusmessage = "Status: Idle";
} else {
	$statusmessage = "<b>Status:</b> Content received, checking integrity...<br />";
	$result = $db->Execute("SELECT id,title FROM Obsedb_Mods_sections WHERE title = '$_REQUEST[platform]'");
	if ($result->RecordCount() >= 1)
	{
		$record['section'] = $result->fields['id'];
		$statusmessage .= "<b>Status:</b> USING PLATFORM ID " . $result->fields['id'] . "<br />";

	} else {

		$db->Execute("INSERT INTO Obsedb_Mods_sections (title) VALUES ('$_REQUEST[platform]')");
		$result = $db->Execute("SELECT id,title FROM Obsedb_Mods_sections WHERE title = '$_REQUEST[platform]'");
		$record['section'] = $result->fields['id'];
		$statusmessage .= "<b>Status:</b> CREATING PLATFORM<br />";
	}

	$record['title'] = $_REQUEST['title'];
	$record['published'] = '1';

	$db->AutoExecute('Obsedb_Mods',$record,'INSERT');

	$statusmessage .= "<b>Status:</b> ADDING Mod COMPLETE";
}



?>
<html>
<head>
	<style type="text/css">
	body {
		margin: 3px;
		font-family: Verdana;
		font-size: 11px; }
	</style>
</head>

<body>

<?php echo $statusmessage; ?>

</body>
</html>