<?php
include("../config.php");
include("../sources/auth/auth.inc.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Sector Portal Control Panel</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
	.bar { color: #FFFFFF; font-size: 8pt; padding-left: 4px; font-weight: bold; }
	.border { background-color: #C0C0C0; }
	.formlabel { padding: 5px; font-size: 8pt; font-weight: bold; background-color: #ECECFF; }
	.hmenu { padding: 4px; font-size: xx-small; background: #ECECEC; }
	.main { padding: 10px; }
	.optionmenu { font-size: xx-small; }
	.optionmenu a:link { color: blue; text-decoration: underline; }
	.optionmenu a:active { color: blue; text-decoration: underline; }
	.optionmenu a:hover { color: blue; text-decoration: underline; }
	.optionmenu a:visited { color: blue; text-decoration: underline; }
	.submit { font-family: Verdana; font-size: 8pt; }
	.vmenu { padding: 4px; font-size: xx-small; line-height: 160%; background: #ECECEC; }

	a:link { text-decoration: none; color: #000000; }
	a:visited { text-decoration: none; color: #000000; }
	a:active { text-decoration: none; color: #000000; }
	a:hover { text-decoration: underline; color: #000000; }
	body { background-color: #FFFFFF; font-family: Verdana; font-size: x-small; margin: 0px; }
	input { font-family: Verdana; font-size: 8pt; padding: 1px; }
	select { font-family: Verdana; font-size: 8pt; }
	td { font-size: 8pt; }


	/* special classes */
	.login {
		border: solid 1px #C0C0C0;
		}
</style>
</head>
<body>

	<br /><br />
	<form method="POST" action="<%pwzin%>">
	<table border="0" cellspacing="0" cellpadding="2" class="login" align="center">
		<tr>
			<td>

			<table border="0" cellspacing="2" cellpadding="4">
				<tr>
					<td style="font-size: 12pt; color: #0E2D8D;"><b>Sector Portal Control Panel</b></td>
				</tr>
			</table>
			<table border="0" cellspacing="2" cellpadding="4" align="center">
				<tr>
					<td>You are now logged in, please wait while we redirect you or <a href="index2.php">click here</a>.</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
	</form>

</body>
</html>
