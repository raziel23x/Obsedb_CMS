<?php

/**
*	Obsedb CMS
*	Copyright 2004-2005 Josh Kimbrel
**/

error_reporting(E_ALL ^ E_NOTICE);

if ($_REQUEST['do'] == 'View Matrix')
{
	$refresh = "rcm_matrix.php?do=viewmatrix&type=news&id=$_REQUEST[id]";
}

require_once( 'global.php' );
require_once( '../sources/userNewsClass.php' );

$cp->header();

$links = 	"<a href=news.php?do=add_section>Add Section</a> | "
		   ."<a href=news.php?do=manage_sections>Manage Sections</a> | "
		   ."<a href=news.php?do=add_news>Post Article</a> | "
		   ."<a href=news.php>Manage Articles</a>";

do_module_header('News Manager',$links);

if ($_REQUEST['do'] == 'View Matrix')
{
	SPMessage("Loading content matrix...","rcm_matrix.php?do=viewmatrix&type=news&id=$_REQUEST[id]");
}

if (empty($_REQUEST['do']))
{

	// Fetch array of sections
	$sections = $db->Execute("SELECT * FROM `Obsedb_news_sections` ORDER BY `id`");
	$spSections = array();

	while ( $row = $sections->FetchNextObject())
	{
		$spSections["$row->ID"] = $row->TITLE;
	}

	do_form_header('news.php');
	do_table_header('Latest News');
	if (isset($_REQUEST['s'])) {
		$latestNews = $db->Execute("SELECT id,title,section FROM `Obsedb_news` WHERE `section` = '$_REQUEST[s]' ORDER BY `id` DESC");
	} else {
		$latestNews = $db->Execute("SELECT id,title,section FROM `Obsedb_news` ORDER BY `id` DESC LIMIT 20");
	}
	while ($row = $latestNews->FetchNextObject()) {
		$bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");
		echo '<tr>
				<td bgcolor="'.$bgcolor.'"><input type="radio" name="id" value="'.$row->ID.'"> '.stripslashes($row->TITLE).'</td>
				<td bgcolor="'.$bgcolor.'">'.$spSections["$row->SECTION"].'</td>
			  </tr>';
		}
	echo '<tr>
			<td colspan="2" class="formlabel">
				<input type="submit" name="do" value="Edit News">
				<input type="submit" name="do" value="Delete News">
				<input type="submit" name="do" value="View Matrix">
			</td>
		  </tr>';
	do_table_footer();
	echo '</form>';
	do_table_header('View all news by section');
	echo '<table border="0" cellspacing="0" cellpadding="5">';
	$count = 0;
	foreach ($spSections AS $key => $value) {

		$count++;
		if ($count >= 2) {
			echo "<td width=\"150\" class='formlabel'><b><a href=\"news.php?s=$key\">&raquo; $value</a></b></td></tr>";
			$count = 0;
		} else {
			echo "<tr><td width=\"150\" class='formlabel'><b><a href=\"news.php?s=$key\">&raquo; $value</a></b></td>";
		}
	}
	echo '</table>';
	do_table_footer();

}

if ($_REQUEST['do'] == 'Edit News') {
	$news = $db->Execute("SELECT * FROM `Obsedb_news` WHERE `id` = '$_REQUEST[id]';");
	$sections = FetchSections('Obsedb_news_sections');
	do_form_header('news.php');
	do_table_header('Post New Article');
	do_text_row('Title','title',clean($news->fields['title']));
	do_text_row('Author','author',clean($news->fields['author']));
	do_select_row('Section','section',$sections,$news->fields['section']);
	do_text_row('Creation Date','date',clean($news->fields['date']));
	listArticleImages($news->fields['newsimage']);
	do_textarea_row('Introduction','intro',stripslashes($news->fields['intro']));
	do_textarea_row('Full Text','text',stripslashes($news->fields['text']));
	do_submit_row();
	echo '<input type="hidden" name="do" value="edit_news_confirm">';
	echo '<input type="hidden" name="id" value="'.$news->fields['id'].'">';
	do_table_footer();
	echo '</form>';

	}

if ($_REQUEST['do'] == 'edit_news_confirm') {

	$rs = $db->Execute("SELECT * FROM `Obsedb_news` WHERE `id` = '$_REQUEST[id]'");
	$record = array(
		'title' => $_REQUEST['title'],
		'author' => $_REQUEST['author'],
		'section' => $_REQUEST['section'],
		'intro' => $_REQUEST['intro'],
		'text' => $_REQUEST['text'],
		'date' => $_REQUEST['date'],
		'newsimage' => $_REQUEST['newsimage']
		);
	$sql = $db->GetUpdateSQL($rs, $record);
	$db->Execute($sql);
	echo '<center>News has been updated, <a href="news.php">click here to continue</a>.</center>';

	}

if ($_REQUEST['do'] == 'add_section')
{
	do_form_header('news.php');
	do_table_header("Add Section");
	do_text_row("Title","title");
	do_submit_row();
	echo '<input type="hidden" name="do" value="add_section_confirm">';
	do_table_footer();
	do_form_footer();
}

if ($_REQUEST['do'] == 'Edit Section')
{
	$section = $db->Execute("SELECT * FROM `Obsedb_news_sections` WHERE `id` = '$_REQUEST[id]'");
	do_form_header('news.php');
	do_table_header("Edit Section");
	do_text_row("Title","title",clean($section->fields['title']));
	do_submit_row();
	echo '<input type="hidden" name="do" value="edit_section_confirm">';
	echo '<input type="hidden" name="id" value="' . $section->fields['id'] . '">';
	do_table_footer();
	do_form_footer();
}

if ($_REQUEST['do'] == 'edit_section_confirm')
{
	$rs = $db->Execute("SELECT * FROM `Obsedb_news_sections` WHERE `id` = '$_REQUEST[id]'");
	$record = array(
		'title' => $_REQUEST['title']
		);
	$sql = $db->GetUpdateSQL($rs, $record);
	$db->Execute($sql);
	SPMessage('Success | Changes have been saved.', 'news.php');
}

if ($_REQUEST['do'] == 'add_section_confirm')
{
	$db->Execute("INSERT INTO `Obsedb_news_sections` (title) VALUES ('$_REQUEST[title]');");
	SPMessage('Success | Section has been successfully created.', 'news.php');
}

if ($_REQUEST['do'] == 'add_news')
{
	$sections = FetchSections('Obsedb_news_sections');
	do_form_header('news.php');
	do_table_header('Post New Article');
	do_text_row('Title','title');
	do_text_row('Author','author');
	do_select_row('Section','section',$sections);
	do_text_row('Creation Date','date',date($spconfig['date_format']));
	listArticleImages();
	do_textarea_row('Introduction','intro');
	do_textarea_row('Full Text','text');
	do_submit_row();
	echo '<input type="hidden" name="do" value="add_news_confirm">';
	do_table_footer();
	echo '</form>';
}

if ($_REQUEST['do'] == 'add_news_confirm')
{
	$rs = $db->Execute("SELECT * FROM `Obsedb_news` WHERE `id` = '-1'");
	$record = array(
		'title' => $_REQUEST['title'],
		'author' => $_REQUEST['author'],
		'section' => $_REQUEST['section'],
		'intro' => $_REQUEST['intro'],
		'text' => $_REQUEST['text'],
		'date' => $_REQUEST['date'],
		'newsimage' => $_REQUEST['newsimage']
		);
	$sql = $db->GetInsertSQL($rs, $record);
	$db->Execute($sql);
	SPMessage('Success | News has been successfully added.', 'news.php');
}

if ($_REQUEST['do'] == 'manage_sections')
{
	do_form_header('news.php');
	do_table_header('Sections');

	$result = $db->Execute("SELECT id,title FROM `Obsedb_news_sections` ORDER BY `title`");
	while ($row = $result->FetchNextObject()) {
		$bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");
		echo '<tr><td bgcolor="'.$bgcolor.'" colspan="2"><input type="radio" value="'.$row->ID.'" name="id"> '.stripslashes($row->TITLE).'</td></tr>';
		}
	echo '<tr>
			<td colspan="2" class="formlabel">
				<input type="submit" name="do" value="Edit Section" style="border: outset 1px; color: #000000; background-image: url(../images/user/button.jpg); font-weight: bold; padding: 2px;">
				<input type="submit" name="do" value="Delete Section">
			</td>
		  </tr>';
	do_table_footer();
	echo '</form>';
}

if ( $_REQUEST['do'] == 'Delete Section' )
{
	$db->Execute("DELETE FROM Obsedb_news_sections WHERE id = $_REQUEST[id]");
	SPMessage( 'Success | Section has been removed.', 'news.php?do=manage_sections' );
}


if ( $_REQUEST['do'] == 'Delete News' )
{
	$db->Execute("DELETE FROM Obsedb_news WHERE id = $_REQUEST[id]");
	SPMessage( 'Success | Article has been removed.', 'news.php' );
}

$cp->footer();

function listArticleImages($selected='')
{
	echo '
		<tr>
			<td class="formlabel" style="text-align: right; font-weight: bold;">Article Image</td>
			<td class="formlabel"><select name="newsimage">
			    <option value="">None</option>';
	$directory = "../images/news_icons/";

	if (is_dir($directory))
	{
		if ($dh = opendir($directory))
		{
			while (($file = readdir($dh)) !== false)
			{
				if ( ($file != '.') && ($file != '..'))
				{
					if ($selected == $file)
					{
						echo "<option selected>$file</option>\n";
					} else {
					    echo "<option>$file</option>\n";
					}
				}
			}
			closedir($dh);
		}
	}

	echo '</select>
			</td>
		</tr>';
}

?>
