<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("global.php");
include_once("../sources/adminPollsClass.php");
$cp->header();
$module = new Module;

$links = '<a href="polls.php?do=add_poll">Add Poll</a> | '
		.'<a href="polls.php">Manage Polls</a>';

do_module_header('Poll Manager',$links);

switch ($_REQUEST['do'])
{
	case 'add_poll':
		$module->add_poll();
		break;
	case 'add_poll_confirm':
		$module->add_poll_confirm();
		break;
	case 'Delete Poll':
		$module->delete();
		break;
	case 'Add Options':
		$module->add_options();
		break;
	case 'add_options_confirm':
		$module->add_options_confirm();
		break;
}

if (!isset($_REQUEST['do']))
{
	$result = $db->Execute("SELECT id,title
							FROM Obsedb_polls
							ORDER BY `id` DESC");
	do_form_header('polls.php');
	do_table_header('Polls');
	while ($row = $result->FetchNextObject())
	{
		$bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");

		echo "<TR>
				<TD BGCOLOR='$bgcolor' COLSPAN='2'>
				<INPUT TYPE='radio' name='id' value='$row->ID'>
				" . stripslashes($row->TITLE) . "</TD>
			  </TR>";
	}

	echo "
			<TR>
				<TD COLSPAN='2' CLASS='formlabel'>
				<INPUT TYPE='submit' NAME='do' VALUE='Delete Poll'>
				<INPUT TYPE='submit' NAME='do' VALUE='Add Options'>
				<INPUT TYPE='submit' NAME='do' VALUE='Edit Poll Title'>
				<INPUT TYPE='submit' NAME='do' VALUE='Edit Poll Options'>
				</TD>
			</TR>";

	do_table_footer();
	do_form_footer();
}

if ($_REQUEST['do'] == 'Edit Poll Options')
{
	$result = $db->Execute("SELECT *
							FROM Obsedb_polls_options
							WHERE poll_id = $_REQUEST[id]
							ORDER BY id DESC");
	do_form_header('polls.php');
	do_table_header('Poll Options');
	while ($row = $result->FetchNextObject())
	{
		$bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");

		echo "<TR>
				<TD BGCOLOR='$bgcolor' COLSPAN='2'>
				<INPUT TYPE='radio' name='id' value='$row->ID'>
				" . stripslashes($row->TEXT) . "</TD>
			  </TR>";
	}

	echo "
			<TR>
				<TD COLSPAN='2' CLASS='formlabel'>
				<INPUT TYPE='submit' NAME='do' VALUE='Edit Option'>
				<INPUT TYPE='submit' NAME='do' VALUE='Delete Option'>
				</TD>
			</TR>";

	do_table_footer();
	do_form_footer();
}

if ($_REQUEST['do'] == 'Edit Option')
{
	$option = $db->Execute("SELECT * FROM Obsedb_polls_options WHERE id = '$_REQUEST[id]'") or die($db->ErrorMsg());
	do_form_header( 'polls.php' );
	do_table_header( 'Editing Poll Option' );
	do_text_row( 'Text', 'text', stripslashes($option->fields['text']));
	do_submit_row('Save Changes');
	do_table_footer();
	echo '<input type="hidden" name="id" value="'.$option->fields['id'].'">';
	echo '<input type="hidden" name="do" value="edit_option_confirm">';

	do_form_footer();
}

if ($_REQUEST['do'] == 'edit_option_confirm')
{
	$result = array(
		'text' => $_REQUEST['text']);

	$db->AutoExecute('Obsedb_polls_options',$result,'UPDATE',"id = '$_REQUEST[id]'");
	SPMessage("Success | Changes have been saved.","polls.php");
}

if ($_REQUEST['do'] == 'Delete Option')
{
	if (!empty($_REQUEST['id']))
	{
		$db->Execute("DELETE FROM Obsedb_polls_options WHERE id = '$_REQUEST[id]'");
		SPMessage("Success | Option has been removed","polls.php");
	} else {
		echo "Error - you must select an option to delete";
	}
}


$cp->footer();

?>