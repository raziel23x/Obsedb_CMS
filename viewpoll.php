<?php

$location = "&raquo; View Poll";
include "global.php";

include "sources/modPollsClass.php";

$module = new Module;

switch($_REQUEST['do'])
{
	default:
		$module->main();
		break;
}

?>