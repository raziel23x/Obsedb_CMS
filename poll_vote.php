<?php

include "global.php";

$id = mysql_real_escape_string($_REQUEST["id"]);

if (empty($id))
{
	header("Location: index.php");
} else {
	$result = $db->Execute("SELECT * FROM Obsedb_polls_options WHERE id = '$id'");

	$ip = $db->Execute("SELECT * FROM Obsedb_polls_iplog WHERE pollid = '" . $result->fields['poll_id'] . "' AND ip = '" . $_SERVER['REMOTE_ADDR'] . "';") or die($db->ErrorMsg());
	if ($ip->RecordCount() < 1)
	{
	$count2 = $result->fields['count'] + 1;
	$db->Execute("UPDATE `Obsedb_polls_options` SET `count` = $count2 WHERE `id` = '$id'");
	$db->Execute("INSERT INTO Obsedb_polls_iplog (pollid,ip) VALUES ('" . $result->fields['poll_id'] . "','" . $_SERVER['REMOTE_ADDR'] . "');");
	}

?>

	<html>
	<head>
		<title><?= $spconfig['site_title']; ?></title>
		<meta http-equiv="refresh" content="2;URL=index.php">
	</head>
	<body>

	<table border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
		<tr>
			<td valign="center" align="center">

			<table border="0" cellspacing="0" cellpadding="10" width="70%">
				<tr>
					<td style="border: 1px solid #C0C0C0;font-family: Verdana;color:#000;font-size:11px;" bgcolor="#F9F9F9">
					Thanks, your vote has been saved.<br />
					Please wait while we transfer you or <a href="index.php">click here to continue</a>.
					</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>

	</body>
	</html>


<?
}

?>