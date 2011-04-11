<?php

switch ($_REQUEST['do'])
{
	case 'add_download_confirm': case 'edit_download_confirm':
		$refresh = "downloads.php?do=manage&id={$_REQUEST['Modid']}";
		break;
	case 'delete':
		$refresh = "downloads.php?do=manage&id={$_REQUEST['Modid']}";
		break;
}

include "global.php";
include "../sources/userDownloadsClass.php";

$module = new Module;
$module->initForm();

?>