<?php

error_reporting(E_ALL ^ E_NOTICE);
include "global.php";
$cp->header();

$links = '<a href="mailbag.php?do=add_mailbag">Add New Letter</a> | '
		.'<a href="mailbag.php">Manage Letters</a>';

do_module_header('Mailbag',$links);

if (empty($_REQUEST['do'])) {

	do_form_header('mailbag.php');
	do_table_header('Latest Letters');
	$latestLetter = $db->Execute("SELECT id,title FROM `Obsedb_mailbag` ORDER BY `id` DESC LIMIT 20");
	while ($row = $latestLetter->FetchNextObject()) {
		$bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");
		echo '<tr>
				<td bgcolor="'.$bgcolor.'"><input type="radio" name="id" value="'.$row->ID.'"> '.stripslashes($row->TITLE).'</td>
			  </tr>';
		}
	echo '<tr>
			<td colspan="2">
				<input type="submit" name="do" value="Edit Letter">
				<input type="submit" name="do" value="Delete Letter">
			</td>
		  </tr>';
	do_table_footer();
	echo '</form>';

	}

if ($_REQUEST['do'] == 'Edit Letter') {
	$mailbag = $db->Execute("SELECT * FROM `Obsedb_mailbag` WHERE `id` = '$_REQUEST[id]';");
	do_form_header('mailbag.php');
	do_table_header('Edit Letter');
	do_text_row('Title','title',clean($mailbag->fields['title']));
	do_textarea_row('Message','message',stripslashes($mailbag->fields['message']));
	do_textarea_row('Reply','reply',stripslashes($mailbag->fields['reply']));
	do_submit_row();
	echo '<input type="hidden" name="do" value="edit_mailbag_confirm">';
	echo '<input type="hidden" name="id" value="'.$mailbag->fields['id'].'">';
	do_table_footer();
	echo '</form>';

	}

if ($_REQUEST['do'] == 'edit_mailbag_confirm') {

	$rs = $db->Execute("SELECT * FROM `Obsedb_mailbag` WHERE `id` = '$_REQUEST[id]'");
	$record = array(
		'title' => $_REQUEST['title'],
		'message' => $_REQUEST['message'],
		'reply' => $_REQUEST['reply']
		);
	$sql = $db->GetUpdateSQL($rs, $record);
	$db->Execute($sql);
	SPMessage("Success | Changes have been saved.","mailbag.php");
	}

if ($_REQUEST['do'] == 'add_mailbag') {

	do_form_header('mailbag.php');
	do_table_header('Add Letter');
	do_text_row('Title','title');
	do_textarea_row('Message','message');
	do_textarea_row('Reply','reply');
	do_submit_row();
	echo '<input type="hidden" name="do" value="add_mailbag_confirm">';
	do_table_footer();
	echo '</form>';

	}

if ($_REQUEST['do'] == 'add_mailbag_confirm')
{
	$record = array(
		'title' => $_REQUEST['title'],
		'message' => $_REQUEST['message'],
		'reply' => $_REQUEST['reply']
		);
	$db->AutoExecute('Obsedb_mailbag',$record,'INSERT');
	SPMessage("Success | Letter has been added.","mailbag.php");
}

if ($_REQUEST['do'] == 'Delete Letter')
{
	$db->Execute("DELETE FROM `Obsedb_mailbag` WHERE `id` = '$_REQUEST[id]'");
	SPMessage("Success | Letter has been deleted.","mailbag.php");
}

$cp->footer();
?>