<form method="post" action="register.php">

<table border="0" cellspacing="0" cellpadding="5">
<tr>
	<td align="right">Username:</td>
	<td><input type="text" name="reg_username" size="20"></td>
</tr>
<tr>
	<td align="right">Email Address:</td>
	<td><input type="text" name="reg_email" size="20"></td>
</tr>
<tr>
	<td align="right">Password:</td>
	<td><input type="password" name="reg_password1" size="20"></td>
</tr>
<tr>
	<td align="right">Confirm Password:</td>
	<td><input type="password" name="reg_password2" size="20"></td>
</tr>
</table><br />
<input type="submit" name="submit" value="Register">

<input type="hidden" name="do" value="register_confirm">

</form>