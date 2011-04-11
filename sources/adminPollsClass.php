<?php

// POLL MANAGER CLASS

class Module
{

	function add_options_confirm()
	{
		global $db;

		$poll_id = $_REQUEST['poll_id'];

		if (!empty( $_REQUEST['option1'] ))
			$options = " ('$poll_id', '$_REQUEST[option1]') ";

		if (!empty( $_REQUEST['option2'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option2]') ";

		if (!empty( $_REQUEST['option3'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option3]') ";

		if (!empty( $_REQUEST['option4'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option4]') ";

		if (!empty( $_REQUEST['option5'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option5]') ";

		if (!empty( $_REQUEST['option6'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option6]') ";

		if (!empty( $_REQUEST['option7'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option7]') ";

		if (!empty( $_REQUEST['option8'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option8]') ";

		if (!empty( $_REQUEST['option9'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option9]') ";

		if (!empty( $_REQUEST['option10'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option10]') ";

		$db->Execute("INSERT INTO `Obsedb_polls_options` (poll_id,text) VALUES $options;");

		SPMessage('Success | Options have been added','polls.php');
	}

	function add_poll_confirm()
	{
		global $db;

		if (empty($_REQUEST['title']))
		{
			die("Error: You must enter a poll title");
		}

		$record["title"] = $_REQUEST['title'];
		$db->AutoExecute('Obsedb_polls',$record,'INSERT');
		$result = $db->Execute("SELECT id FROM Obsedb_polls ORDER BY `id` DESC LIMIT 1");
		$poll_id = $result->fields['id'];

		if (!empty( $_REQUEST['option1'] ))
			$options = " ('$poll_id', '$_REQUEST[option1]') ";

		if (!empty( $_REQUEST['option2'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option2]') ";

		if (!empty( $_REQUEST['option3'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option3]') ";

		if (!empty( $_REQUEST['option4'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option4]') ";

		if (!empty( $_REQUEST['option5'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option5]') ";

		if (!empty( $_REQUEST['option6'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option6]') ";

		if (!empty( $_REQUEST['option7'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option7]') ";

		if (!empty( $_REQUEST['option8'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option8]') ";

		if (!empty( $_REQUEST['option9'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option9]') ";

		if (!empty( $_REQUEST['option10'] ))
			$options .= ", ('$poll_id', '$_REQUEST[option10]') ";

		$db->Execute("INSERT INTO `Obsedb_polls_options` (poll_id,text) VALUES $options;");

		SPMessage('Success | Poll has been created','polls.php');
	}

	function delete()
	{
		global $db;
		$db->Execute("DELETE FROM `Obsedb_polls` WHERE `id` = '$_REQUEST[id]'");
		$db->Execute("DELETE FROM `Obsedb_polls_options` WHERE `poll_id` = '$_REQUEST[id]'");
		SPMessage('Success | Poll has been removed','polls.php');
	}

	function add_options()
	{
		global $db;
		do_form_header('polls.php');

		do_table_header('Poll Options');
		do_text_row('Option 1','option1');
		do_text_row('Option 2','option2');
		do_text_row('Option 3','option3');
		do_text_row('Option 4','option4');
		do_text_row('Option 5','option5');
		do_text_row('Option 6','option6');
		do_text_row('Option 7','option7');
		do_text_row('Option 8','option8');
		do_text_row('Option 9','option9');
		do_text_row('Option 10','option10');
		do_submit_row('Add Poll');
		echo '<input type="hidden" name="poll_id" value="'.$_REQUEST['id'].'">';
		echo '<input type="hidden" name="do" value="add_options_confirm">';
		do_table_footer();
		do_form_footer();
	}

	function add_poll()
	{
		global $db;
		do_form_header('polls.php');
		do_table_header('Add New Poll');
		do_text_row('Title','title');

		do_table_footer();

		do_table_header('Poll Options');
		do_text_row('Option 1','option1');
		do_text_row('Option 2','option2');
		do_text_row('Option 3','option3');
		do_text_row('Option 4','option4');
		do_text_row('Option 5','option5');
		do_text_row('Option 6','option6');
		do_text_row('Option 7','option7');
		do_text_row('Option 8','option8');
		do_text_row('Option 9','option9');
		do_text_row('Option 10','option10');
		do_submit_row('Add Poll');
		do_table_footer();


		echo('<input type="hidden" name="do" value="add_poll_confirm">');
		do_form_footer();

		echo "You may add more options later if you need more than ten.";
	}

}
?>