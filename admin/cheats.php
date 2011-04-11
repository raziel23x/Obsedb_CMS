<?php

switch ($_REQUEST['do'])
{
	case 'add_confirm': case 'edit_confirm':
		$refresh = "cheats.php?do=manage&id={$_REQUEST['Modid']}";
		break;
	case 'delete':
		$refresh = "cheats.php?do=manage&id={$_REQUEST['Modid']}";
		break;
}

include "global.php";
include "../sources/adminCheatsClass.php";

$module = new Module;
$module->initForm();

?>