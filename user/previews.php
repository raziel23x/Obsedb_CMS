<?php
error_reporting(E_ALL ^ E_NOTICE);
if ($_REQUEST['do'] == 'View Matrix') {
	$refresh = "rcm_matrix.php?do=viewmatrix&type=previews&id=$_REQUEST[id]";
	}
include "global.php";
include("../sources/userPreviewsClass.php");
$cp->header();
$links = "<a href=previews.php?do=add_section>Add Section</a> | "
		."<a href=previews.php?do=manage_sections>Manage Sections</a> | "
		."<a href=previews.php?do=add_news>Add Preview</a> | "
		."<a href=previews.php>Manage Previews</a>";

do_module_header('Preview Manager',$links);

if ($_REQUEST['do'] == 'View Matrix') {
	echo "<br /><br /><center><b><h3>Loading content matrix...</h3></b></center>";
	}
if (empty($_REQUEST['do'])) {

	// Fetch array of sections
	$sections = $db->Execute("SELECT * FROM `Obsedb_previews_sections` ORDER BY `id`");
	$spSections = array();
	while ($row = $sections->FetchNextObject()) {
		$spSections["$row->ID"] = $row->TITLE;
		}
	do_form_header('previews.php');
	do_table_header('Latest Preview');
	if (isset($_REQUEST['s'])) {
		$latestPreview = $db->Execute("SELECT id,title,section FROM `Obsedb_previews` WHERE `section` = '$_REQUEST[s]' ORDER BY `id` DESC");
	} else {
		$latestPreview = $db->Execute("SELECT id,title,section FROM `Obsedb_previews` ORDER BY `id` DESC LIMIT 20");
	}
	while ($row = $latestPreview->FetchNextObject()) {
		$bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");
		echo '<tr>
				<td bgcolor="'.$bgcolor.'"><input type="radio" name="id" value="'.$row->ID.'"> '.$row->TITLE.'</td>
				<td bgcolor="'.$bgcolor.'">'.$spSections["$row->SECTION"].'</td>
			  </tr>';
		}
	echo '<tr>
			<td colspan="2">
				<input type="submit" name="do" value="Edit Preview">
				<input type="submit" name="do" value="Delete Preview">
				<input type="submit" name="do" value="View Matrix">
			</td>
		  </tr>';
	do_table_footer();
	echo '</form>';
	do_table_header('View all news by section');
	echo '<table border="0" cellspacing="5" cellpadding="0">';
	$count = 0;
	foreach ($spSections AS $key => $value) {

		$count++;
		if ($count >= 2) {
			echo "<td width=\"150\"><b><a href=\"previews.php?s=$key\">&raquo; $value</a></b></td></tr>";
			$count = 0;
		} else {
			echo "<tr><td width=\"150\"><b><a href=\"previews.php?s=$key\">&raquo; $value</a></b></td>";
		}
	}
	echo '</table>';
	do_table_footer();

	}

if ($_REQUEST['do'] == 'Edit Preview') {
	$news = $db->Execute("SELECT * FROM `Obsedb_previews` WHERE `id` = '$_REQUEST[id]';");
	do_form_header('previews.php');
	do_table_header('Post New Preview');
	do_text_row('Title','title',clean($news->fields['title']));
	do_sections_row($news->fields['section']);
	do_textarea_row('Introduction','intro',stripslashes($news->fields['intro']));
	do_textarea_row('Full Text','text',stripslashes($news->fields['text']));
	do_submit_row();
	echo '<input type="hidden" name="do" value="edit_news_confirm">';
	echo '<input type="hidden" name="id" value="'.$news->fields['id'].'">';
	do_table_footer();
	echo '</form>';

	}

if ($_REQUEST['do'] == 'edit_news_confirm') {

	$rs = $db->Execute("SELECT * FROM `Obsedb_previews` WHERE `id` = '$_REQUEST[id]'");
	$record = array(
		'title' => $_REQUEST['title'],
		'section' => $_REQUEST['section'],
		'intro' => $_REQUEST['intro'],
		'text' => $_REQUEST['text']
		);
	$sql = $db->GetUpdateSQL($rs, $record);
	$db->Execute($sql);
	echo '<center>Preview has been updated, <a href="previews.php">click here to continue</a>.</center>';

	}

if ($_REQUEST['do'] == 'add_section') {

	do_form_header('previews.php');
	do_table_header("Add Section");
	do_text_row("Title","title");
	do_submit_row();
	echo '<input type="hidden" name="do" value="add_section_confirm">';
	do_table_footer();
	echo '</form>';

	}

if ($_REQUEST['do'] == 'Edit Section') {
	$section = $db->Execute("SELECT * FROM `Obsedb_previews_sections` WHERE `id` = '$_REQUEST[id]'");
	do_form_header('previews.php');
	do_table_header("Edit Section");
	do_text_row("Title","title",clean($section->fields['title']));
	do_submit_row();
	echo '<input type="hidden" name="do" value="edit_section_confirm">';
	echo '<input type="hidden" name="id" value="' . $section->fields['id'] . '">';
	do_table_footer();
	echo '</form>';

	}

if ($_REQUEST['do'] == 'edit_section_confirm') {

	$rs = $db->Execute("SELECT * FROM `Obsedb_previews_sections` WHERE `id` = '$_REQUEST[id]'");
	$record = array(
		'title' => $_REQUEST['title']
		);
	$sql = $db->GetUpdateSQL($rs, $record);
	$db->Execute($sql);
	echo '<center>Changes have been saved, <a href="previews.php">click here to continue</a>.</center>';

	}

if ($_REQUEST['do'] == 'add_section_confirm') {

	$db->Execute("INSERT INTO `Obsedb_previews_sections` (title) VALUES ('$_REQUEST[title]');");
	echo '<center>Section has been successfully created, <a href="previews.php">click here to continue</a>.</center>';

	}

if ($_REQUEST['do'] == 'add_news') {

	do_form_header('previews.php');
	do_table_header('Post New Preview');
	do_text_row('Title','title');
	do_sections_row();
	do_textarea_row('Introduction','intro');
	do_textarea_row('Full Text','text');
	do_submit_row();
	echo '<input type="hidden" name="do" value="add_news_confirm">';
	do_table_footer();
	echo '</form>';

	}

if ($_REQUEST['do'] == 'add_news_confirm') {

	$rs = $db->Execute("SELECT * FROM `Obsedb_previews` WHERE `id` = '-1'");
	$record = array(
		'title' => $_REQUEST['title'],
		'section' => $_REQUEST['section'],
		'intro' => $_REQUEST['intro'],
		'text' => $_REQUEST['text']
		);
	$sql = $db->GetInsertSQL($rs, $record);
	$db->Execute($sql);
	echo '<center>Preview has been successfully added, <a href="previews.php">click here to continue</a>.</center>';

	}

if ($_REQUEST['do'] == 'manage_sections') {
	do_form_header('previews.php');
	do_table_header('Sections');

	$result = $db->Execute("SELECT id,title FROM `Obsedb_previews_sections` ORDER BY `title`");
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

	$db->Execute("DELETE FROM `Obsedb_previews_sections` WHERE `id` = '$_REQUEST[id]'");
	echo '<center>Section has been successfully removed, <a href="previews.php?do=manage_sections">click here to continue</a>.</center>';
	}
if ($_REQUEST['do'] == 'Delete Preview') {

	$db->Execute("DELETE FROM `Obsedb_previews` WHERE `id` = '$_REQUEST[id]'");
	echo '<center>Preview article has been successfully removed, <a href="previews.php">click here to continue</a>.</center>';
	}

$cp->footer();

?>