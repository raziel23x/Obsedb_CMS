<?php

error_reporting(E_ALL ^ E_NOTICE);
include "global.php";
$cp->header();
$links = "<a href=links.php?do=add_section>Add Section</a> | "
		."<a href=links.php?do=manage_sections>Manage Sections</a> | "
		."<a href=links.php?do=add_link>Add Link</a> | "
		."<a href=links.php>Manage Links</a>";

do_module_header('Link Manager',$links);

if (!isset($_REQUEST['do'])) {
	// Fetch array of sections
	$sections = $db->Execute("SELECT * FROM `Obsedb_links_sections` ORDER BY `id`");
	$spSections = array();
	while ($row = $sections->FetchNextObject()) {
		$spSections["$row->ID"] = $row->TITLE;
		}


	do_form_header('links.php');
	do_table_header('Latest Links');
	if (isset($_REQUEST['s'])) {
		$latestLink = $db->Execute("SELECT id,title,section FROM `Obsedb_links` WHERE `section` = '$_REQUEST[s]' ORDER BY `id` DESC");
	} else {
		$latestLink = $db->Execute("SELECT id,title,section FROM `Obsedb_links` ORDER BY `id` DESC LIMIT 20");
	}
	while ($row = $latestLink->FetchNextObject()) {
		$bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");
		echo '<tr>
				<td bgcolor="'.$bgcolor.'"><input type="radio" name="id" value="'.$row->ID.'"> '.$row->TITLE.'</td>
				<td bgcolor="'.$bgcolor.'">'.$spSections["$row->SECTION"].'</td>
			  </tr>';
		}
	echo '<tr>
			<td colspan="2">
				<input type="submit" name="do" value="Edit Link">
				<input type="submit" name="do" value="Delete Link">
			</td>
		  </tr>';
	do_table_footer();
	echo '</form>';


	do_table_header('View all links by section');
	echo '<table border="0" cellspacing="5" cellpadding="0">';
	$count = 0;
	foreach ($spSections AS $key => $value) {

		$count++;
		if ($count >= 2) {
			echo "<td width=\"150\"><b><a href=\"links.php?s=$key\">&raquo; $value</a></b></td></tr>";
			$count = 0;
		} else {
			echo "<tr><td width=\"150\"><b><a href=\"links.php?s=$key\">&raquo; $value</a></b></td>";
		}
	}
	echo '</table>';
	do_table_footer();
}

if ($_REQUEST['do'] == 'add_link') {

	do_form_header('links.php');
	do_table_header('Add Link');
	do_text_row('Title','title');
	do_text_row('URL','url');

	$sections = $db->Execute("SELECT id,title FROM `Obsedb_links_sections` ORDER BY `title`");
	echo '<tr><td class="formlabel">Section</td><td class="formlabel"><select name="section">';
	echo '<option value="null">- Sections -</option>';
	while ($row = $sections->FetchNextObject()) {
		if ($row->ID == $sel) {
			echo '<option value="' . $row->ID . '" selected>' . stripslashes($row->TITLE) . '</option>\n';
		} else {
			echo '<option value="' . $row->ID . '">' . stripslashes($row->TITLE) . '</option>\n';
		}
	}
	echo '</select></td></tr>';

	do_submit_row('Add Link');
	do_table_footer();
	echo '<input type="hidden" name="do" value="add_link_confirm">';
	echo '</form>';
	}

if ($_REQUEST['do'] == 'add_link_confirm') {

	$rs = $db->Execute("SELECT * FROM `Obsedb_links` WHERE `id` = '-1'");
	$record = array(
		'title' => $_REQUEST['title'],
		'url' => $_REQUEST['url'],
		'section' => $_REQUEST['section']
		);
	$sql = $db->GetInsertSQL($rs, $record);
	$db->Execute($sql);
	echo '<center>Link has been successfully added, <a href="links.php">click here to continue</a>.</center>';
	}

if ($_REQUEST['do'] == 'edit_link_confirm') {

	$rs = $db->Execute("SELECT * FROM `Obsedb_links` WHERE `id` = '{$_REQUEST['id']}'");
	$record = array(
		'title' => $_REQUEST['title'],
		'url' => $_REQUEST['url'],
		'section' => $_REQUEST['section']
		);
	$sql = $db->GetUpdateSQL($rs, $record);
	$db->Execute($sql);
	SPMessage('Success: Link has been updated.','links.php');
	}

if ($_REQUEST['do'] == 'Edit Link') {

	$link = $db->Execute("SELECT * FROM `Obsedb_links` WHERE `id` = '" . $_REQUEST['id'] . "'");
	$sections = FetchSections('Obsedb_links_sections');

	$fields = array(

		'title' => array( 'type' => 'text', 'title' => 'Title', 'name' => 'title', 'value' => clean($link->fields['title']) ),
		'url' => array( 'type' => 'text', 'title' => 'URL', 'name' => 'url', 'value' => clean($link->fields['url']) ),
		'section' => array( 'type' => 'select', 'title' => 'Section', name => 'section', 'value' => $sections, 'selected' => $link->fields['section']),
		'submit' => array( 'type' => 'submit', 'title' => 'Save Link')

		);

	$hidden = array('id' => $_REQUEST['id']);
	GenerateForm('links.php','Edit Link','edit_link_confirm',$fields,$hidden);

	}

if ($_REQUEST['do'] == 'add_section') {

	do_form_header('links.php');
	do_table_header("Add Section");
	do_text_row("Title","title");
	do_submit_row();
	echo '<input type="hidden" name="do" value="add_section_confirm">';
	do_table_footer();
	echo '</form>';

	}

if ($_REQUEST['do'] == 'Edit Section') {
	$section = $db->Execute("SELECT * FROM `Obsedb_links_sections` WHERE `id` = '$_REQUEST[id]'");
	do_form_header('links.php');
	do_table_header("Edit Section");
	do_text_row("Title","title",clean($section->fields['title']));
	do_submit_row();
	echo '<input type="hidden" name="do" value="edit_section_confirm">';
	echo '<input type="hidden" name="id" value="' . $section->fields['id'] . '">';
	do_table_footer();
	echo '</form>';

	}

if ($_REQUEST['do'] == 'edit_section_confirm') {

	$rs = $db->Execute("SELECT * FROM `Obsedb_links_sections` WHERE `id` = '$_REQUEST[id]'");
	$record = array(
		'title' => $_REQUEST['title']
		);
	$sql = $db->GetUpdateSQL($rs, $record);
	$db->Execute($sql);
	SPMessage('Success: Section has been updated.','links.php?do=manage_sections');

	}

if ($_REQUEST['do'] == 'add_section_confirm') {

	$db->Execute("INSERT INTO `Obsedb_links_sections` (title) VALUES ('$_REQUEST[title]');");
	SPMessage('Success: Section has been created.','links.php?do=manage_sections');

	}
if ($_REQUEST['do'] == 'manage_sections') {
	do_form_header('links.php');
	do_table_header('Sections');

	$result = $db->Execute("SELECT id,title FROM `Obsedb_links_sections` ORDER BY `title`");
	while ($row = $result->FetchNextObject()) {
		$bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");
		echo '<tr><td bgcolor="'.$bgcolor.'" colspan="2"><input type="radio" value="'.$row->ID.'" name="id"> '.stripslashes($row->TITLE).'</td></tr>';
		}
	echo '<tr>
			<td colspan="2">
				<input type="submit" name="do" value="Edit Section">
				<input type="submit" name="do" value="Delete Section">
			</td>
		  </tr>';
	do_table_footer();
	echo '</form>';
	}

if ($_REQUEST['do'] == 'Delete Section') {

	$db->Execute("DELETE FROM `Obsedb_links_sections` WHERE `id` = '$_REQUEST[id]'");
	SPMessage('Success: Section has been deleted.','links.php?do=manage_sections');
	}
$cp->footer();
?>