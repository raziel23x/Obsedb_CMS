<?php
/*
##############################################################
 Obsedb CMS Content Management System
 Copyright (C) 2009  Joshua Kimbrel

 This program is free software; you can redistribute it and/or modify
 it under the terms of the BSD License as published by
 the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 BSD License for more details.

 
##############################################################
*/

error_reporting(E_ALL & ~E_NOTICE);
@set_magic_quotes_runtime(0);

$location .= " > <b>Register New Account</b>";

require_once("global.php");

do_header();

switch($_REQUEST['do'])
{
	case 'register_confirm':
		create_user_account();
		break;
	default:
		print_registration_form();
		break;
}

do_footer();

function print_registration_form()
{
	global $userinfo;
	if ($userinfo[id] != '0')
	{
		print "You are already a registered user.";
	} else {
		require_once("templates/registration_form.inc.php");
	}
}

function create_user_account()
{
	global $db;
	if ($_REQUEST['reg_password1'] == '')
	{
		die("Error: Password field cannot be empty.");
	}
	if ($_REQUEST['reg_password1'] != $_REQUEST['reg_password2'])
	{
		die("Error: Passwords do not match.");
	}
	if ($_REQUEST['reg_username'] == '')
	{
		die("Error: Username field cannot be empty.");
	}
	if ($_REQUEST['reg_email'] == '')
	{
		die("Error: Email address field cannot be empty.");
	}
	$reg_username = mysql_real_escape_string($_REQUEST['reg_username']);
	$reg_password = mysql_real_escape_string($_REQUEST['reg_password1']);
	$reg_email = mysql_real_escape_string($_REQUEST['reg_email']);
	$check_username = $db->Execute("SELECT username FROM Obsedb_users WHERE `username` = '$reg_username';");
	if ($check_username->RecordCount() >= 1)
	{
		die("Error: That username is already taken.");
	}
	$check_email = $db->Execute("SELECT email FROM Obsedb_users WHERE `email` = '$reg_email';");
	if ($check_email->RecordCount() >= 1)
	{
		die("Error: That email address is already taken.");
	}

	$rs = $db->Execute("SELECT * FROM Obsedb_users WHERE id = '-1';");
	$record['username'] = $reg_username;
	$record['password'] = md5($reg_password);
	$record['email'] = $reg_email;
	$sql = $db->GetInsertSQL($rs,$record);
	$db->Execute($sql);
}

?>