<?php

if ($userinfo[id] == '0')
{
?>
	<div style="padding: 5px; border: 1px solid #f5f5f5;">
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td align="right">Username: </td>
			<td> <input type="text" name="username" size="20"></td>
			<td align="right">Password: </td>
			<td> <input type="password" name="password" size="20"></td>
			<td align="right"><input type="submit" name="submit" value="Log in"></td>
		</tr>
		</form>
	</table>
	</div><br />

<?php

} else {

print "Logged in as: $userinfo[username]<br />";

}

?>