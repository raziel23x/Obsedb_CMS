<?php

error_reporting(E_ALL ^ E_NOTICE);
require_once("../config.php");
require_once("../sources/auth/auth.inc.php");

?>
<html>
<head>
	<title>Obsedb CMS Admin Control Panel</title>
	<meta http-equiv="refresh" content="4;URL=index2.php">
</head>
<body>

<table border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
	<tr>
		<td valign="center" align="center">

		<table border="0" cellspacing="0" cellpadding="10" width="70%">
			<tr>
				<td style="border: 1px solid #C0C0C0;font-family: Verdana;color:#000;font-size:11px;" bgcolor="#F9F9F9">
				Success: You are now logged in.<br />
				Please wait while we transfer you to your control panel or <a href="index2.php">click here to continue</a>.
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>

</body>
</html>