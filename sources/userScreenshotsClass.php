<?php

class Module
{

	function header()
	{
		global $db;

		$links = '<a href="screenshots.php?do=add_section">Add Section</a> | '
				  .'<a href="screenshots.php?do=manage_sections">Manage Sections</a> | '
				  .'<a href="screenshots.php?do=add_screenshot">Add Screenshot</a> | '
				  .'<a href="screenshots.php?">Manage Screenshots</a>';

		do_module_header('Screenshots',$links);
	}

	function edit_section_confirm()
	{
		global $db;
		$record = array(
			'title' => $_REQUEST['title'] );

		$db->AutoExecute( 'Obsedb_screenshots_sections', $record, 'UPDATE', "id = {$_REQUEST['id']}");
		SPMessage('Success | Section has been updated.','screenshots.php');
	}

	function edit_section()
	{
		global $db;

		$result = $db->Execute("SELECT * FROM Obsedb_screenshots_sections WHERE id = $_REQUEST[id]");
		if ($result)
		{
			$row = $result->FetchRow();

			do_form_header( "screenshots.php" );
			do_table_header( "Edit Section" );
			do_text_row( "Title", "title", stripslashes($row[title]) );
			do_submit_row("Update");

			echo '<input type="hidden" name="do" value="edit_section_confirm">';
			echo '<input type="hidden" name="id" value="' . $row[id] . '">';

			do_table_footer();
			do_form_footer();
		}
	}

	function add_section()
	{
		do_form_header( "screenshots.php" );
		do_table_header( "Add Section" );
		do_text_row( "Title", "title" );
		do_submit_row( "Add Section" );

		echo '<input type="hidden" name="do" value="add_section_confirm">';

		do_table_footer();
		do_form_footer();
	}

}

?>