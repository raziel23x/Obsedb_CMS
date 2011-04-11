<?php
error_reporting(E_ALL ^ E_NOTICE);
include "global.php";
include "../sources/adminUsersClass.php";
include("../language/default/admin_users.php");
$cp->header();

$module = new Module;


if (defined('SUPERADMIN_MODE'))
{
	$module->header();

	switch($_REQUEST['do'])
	{
		case 'add_user':
			$module->add_user();
			break;
		case 'add_confirm':
			$module->add_confirm();
			break;
		case 'Delete User':
			$module->delete_user();
			break;
		case 'Edit User':
			$module->edit_user();
			break;
		case 'edit_confirm':
			$module->edit_confirm();
			break;
		case 'Reset Password':
			$module->reset_password();
			break;
		case 'reset_confirm':
			$module->reset_confirm();
			break;
		default:
			$module->manage_users();
			break;
	}

} else {

	echo "You do not have super administrator permissions.";

}

$cp->footer();


?>