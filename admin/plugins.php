<?php

include "global.php";
$cp->header();

define('Obsedb_LOADED',true);

do_module_header('Plugin Manager');

do_table_header('Installed Plugins');
foreach(glob("../sources/admin_plugins/*.plugin") AS $filename) {
	include("$filename");
	?>

		<tr>
			<td class="formlabel">
			<a href="loadplugin.php?load=<?php echo $plugin_filename; ?>"><b><?php echo $plugin_title; ?></b></a>
			</td>
		</tr>

	<?php
	}

do_table_footer();
$cp->footer();
?>