<?php
class Module
{

    function do_Mod_select_row( $Modid = '' )
    {
        global $db;
        $result = $db->Execute("SELECT g.id,g.title,p.title AS `platform` FROM Obsedb_Mods AS g, Obsedb_Mods_sections AS p WHERE g.section = p.id ORDER BY g.title");
        $Mods['0'] = 'None';
        while ($row = $result->FetchNextObject())
        {
            $Mods[$row->ID] = stripslashes($row->TITLE) . " (" . stripslashes($row->PLATFORM) . ")";
        }
        do_select_row("Mod","Modid",$Mods,$Modid);
    }

	function addReview()
	{
		global $db;

		$sections = FetchSections('Obsedb_reviews_sections');
		do_form_header('reviews.php');
		do_table_header('Post New Review');
		do_text_row('Title','title');
		do_select_row('Section','section',$sections);
		$this->do_Mod_select_row();
		do_text_row( "Modplay", "Modplay" );
		do_text_row( "Graphics", "graphics" );
		do_text_row( "Sound", "sound" );
		do_text_row( "Value", "value" );
		do_text_row( "Tilt", "tilt" );
		do_textarea_row('Introduction','intro');
		do_textarea_row('Full Text','text');
		do_submit_row();
		do_table_footer();
		echo '<input type="hidden" name="do" value="add_news_confirm">';
		echo '</form>';
	}

	function addSection()
	{
		global $db;
		do_form_header('reviews.php');
		do_table_header("Add Section");
		do_text_row("Title","title");
		do_submit_row();
		echo '<input type="hidden" name="do" value="add_section_confirm">';
		do_table_footer();
		echo '</form>';
	}


	function deleteReview()
	{
		global $db;
		$db->Execute("DELETE FROM Obsedb_reviews WHERE id = '$_REQUEST[id]';");
		SPMessage( "Success | Review has been deleted.", "reviews.php" );
	}


	function deleteSection()
	{
		global $db;
		$db->Execute("DELETE FROM Obsedb_reviews_sections WHERE id = '$_REQUEST[id]';");
		SPMessage( "Success | Section has been deleted.", "reviews.php?do=manage_sections" );
	}


	function editReview()
	{
		global $db;

		$sections = FetchSections('Obsedb_reviews_sections');
		$review = $db->Execute("SELECT * FROM `Obsedb_reviews` WHERE `id` = '$_REQUEST[id]';");
		do_form_header('reviews.php');
		do_table_header('Post New Review');
		do_text_row('Title','title',clean($review->fields['title']));
		do_select_row('Section','section',$sections,$review->fields['section']);
		$this->do_Mod_select_row( $review->fields['Modid'] );
		do_text_row( "Modplay", "Modplay", clean($review->fields['Modplay']) );
		do_text_row( "Graphics", "graphics", clean($review->fields['graphics']) );
		do_text_row( "Sound", "sound", clean($review->fields['sound']) );
		do_text_row( "Value", "value", clean($review->fields['value']) );
		do_text_row( "Tilt", "tilt", clean($review->fields['tilt']) );
		do_textarea_row('Introduction','intro',stripslashes($review->fields['intro']));
		do_textarea_row('Full Text','text',stripslashes($review->fields['text']));
		do_submit_row();
		echo '<input type="hidden" name="do" value="edit_review_confirm">';
		echo '<input type="hidden" name="id" value="'.$review->fields['id'].'">';
		do_table_footer();
		echo '</form>';
	}


	function editSection()
	{
		global $db;

		$section = $db->Execute("SELECT * FROM `Obsedb_reviews_sections` WHERE `id` = '$_REQUEST[id]'");
		do_form_header('reviews.php');
		do_table_header("Edit Section");
		do_text_row("Title","title",stripslashes($section->fields['title']));
		do_submit_row();
		echo '<input type="hidden" name="do" value="edit_section_confirm">';
		echo '<input type="hidden" name="id" value="' . $section->fields['id'] . '">';
		do_table_footer();
		echo '</form>';
	}


	function manageReviews()
	{
		global $db;
		// Fetch array of sections
		$sections = $db->Execute("SELECT * FROM `Obsedb_reviews_sections` ORDER BY `id`");
		$spSections = array();
		while ($row = $sections->FetchNextObject()) {
			$spSections["$row->ID"] = $row->TITLE;
			}
		do_form_header('reviews.php');
		do_table_header('Latest Review');
		if (isset($_REQUEST['s'])) {
			$latestReview = $db->Execute("SELECT id,title,section FROM `Obsedb_reviews` WHERE `section` = '$_REQUEST[s]' ORDER BY `id` DESC");
		} else {
			$latestReview = $db->Execute("SELECT id,title,section FROM `Obsedb_reviews` ORDER BY `id` DESC LIMIT 20");
		}
		while ($row = $latestReview->FetchNextObject()) {
			$bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");
			echo '<tr>
					<td bgcolor="'.$bgcolor.'"><input type="radio" name="id" value="'.$row->ID.'"> '.$row->TITLE.'</td>
					<td bgcolor="'.$bgcolor.'">'.$spSections["$row->SECTION"].'</td>
				  </tr>';
			}
		echo '<tr>
				<td colspan="2" class="formlabel">
					<input type="submit" name="do" value="Edit Review">
					<input type="submit" name="do" value="Delete Review">
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
				echo "<td width=\"150\"><b><a href=\"reviews.php?s=$key\">&raquo; $value</a></b></td></tr>";
				$count = 0;
			} else {
				echo "<tr><td width=\"150\"><b><a href=\"reviews.php?s=$key\">&raquo; $value</a></b></td>";
			}
		}
		echo '</table>';
		do_table_footer();
	}


	function manageSections()
	{
		global $db;
		do_form_header('reviews.php');
		do_table_header('Sections');

		$result = $db->Execute("SELECT id,title FROM `Obsedb_reviews_sections` ORDER BY `title`");
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


	function insertReview()
	{
		global $db;
		$rs = $db->Execute("SELECT * FROM `Obsedb_reviews` WHERE `id` = '-1'");
		$record = array(
			'title' => $_REQUEST['title'],
			'section' => $_REQUEST['section'],
			'Modid' => $_REQUEST['Modid'],
			'intro' => $_REQUEST['intro'],
			'text' => $_REQUEST['text'],
			'Modplay' => $_REQUEST['Modplay'],
			'graphics' => $_REQUEST['graphics'],
			'sound' => $_REQUEST['sound'],
			'value' => $_REQUEST['value'],
			'tilt' => $_REQUEST['tilt']
			);
		$sql = $db->GetInsertSQL($rs, $record);
		$db->Execute($sql);
		SPMessage('Success | Review has been posted successfully.','reviews.php');
	}


	function insertSection()
	{
		global $db;
		$db->Execute("INSERT INTO `Obsedb_reviews_sections` (title) VALUES ('$_REQUEST[title]');");
		SPMessage('Success | Section has been created successfully','reviews.php');
	}


	function updateReview()
	{
		global $db;
		$rs = $db->Execute("SELECT * FROM `Obsedb_reviews` WHERE `id` = '$_REQUEST[id]'");
		$record = array(
			'title' => $_REQUEST['title'],
			'section' => $_REQUEST['section'],
			'Modid' => $_REQUEST['Modid'],
			'intro' => $_REQUEST['intro'],
			'text' => $_REQUEST['text'],
			'Modplay' => $_REQUEST['Modplay'],
			'graphics' => $_REQUEST['graphics'],
			'sound' => $_REQUEST['sound'],
			'value' => $_REQUEST['value'],
			'tilt' => $_REQUEST['tilt']
			);
		$sql = $db->GetUpdateSQL($rs, $record);
		$db->Execute($sql);
		Success("Success | Review has been updated.", "reviews.php");
	}


	function updateSection()
	{
		global $db;

		$rs = $db->Execute("SELECT * FROM `Obsedb_reviews_sections` WHERE `id` = '$_REQUEST[id]'");
		$record = array(
			'title' => $_REQUEST['title']
			);
		$sql = $db->GetUpdateSQL($rs, $record);
		$db->Execute($sql);
		SPMessage("Success | Section has been saved.","reviews.php");
	}
}

?>