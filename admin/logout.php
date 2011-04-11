<?php
/************************************************************************/
/* PWZ_AUTH v2.2      	                                                */
/* ===================================                                  */
/*                                                                      */
/* http://opensource.spidmail.net                                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the BSD License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

error_reporting(E_ALL);
include("../config.php");
include("../sources/auth/auth_settings.inc.php");
SetCookie($pwzcookie,"",time() - 3600,"/","");

?>

<html>
<head>
	<title>Obsedb CMS Admin Control Panel</title>
	<meta http-equiv="refresh" content="2;URL=login.php">
</head>
<body>

<table border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
	<tr>
		<td valign="center" align="center">

		<table border="0" cellspacing="0" cellpadding="10" width="70%">
			<tr>
				<td style="border: 1px solid #C0C0C0;font-family: Verdana;color:#000;font-size:11px;" bgcolor="#F9F9F9">
				Success: You are now logged out.<br />
				Please wait while we transfer you to your login page or <a href="login.php">click here to continue</a>.
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>

</body>
</html>