<?php

switch ($_REQUEST['do'])
{
	case 'View Matrix':
		$refresh = "rcm_matrix.php?do=viewmatrix&type=companies&id=" . $_REQUEST[id];
		break;
	case 'add_confirm':
		$refresh = "companies.php";
		break;
	case 'edit_confirm':
		$refresh = "companies.php";
		break;
}

include "global.php";
include "../sources/userCompaniesClass.php";

$module = new Module;
$module->initForm();

?>