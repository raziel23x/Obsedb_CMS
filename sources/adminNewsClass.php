<?php

function do_sections_row($sel='') {
	global $db;
	$result = $db->Execute("SELECT id,title FROM `Obsedb_news_sections` ORDER BY `title`");

	echo '<tr><td class="formlabel">Section</td><td class="formlabel"><select name="section">';

	echo '<option value="null">- Sections -</option>';

	while ($row = $result->FetchNextObject()) {

		if ($row->ID == $sel) {
			echo '<option value="' . $row->ID . '" selected>' . stripslashes($row->TITLE) . '</option>\n';
		} else {
			echo '<option value="' . $row->ID . '">' . stripslashes($row->TITLE) . '</option>\n';
		}



	}

	echo '</select></td></tr>';

	}

?>