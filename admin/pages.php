<?php


error_reporting(E_ALL ^ E_NOTICE);

if ($_REQUEST['do'] == 'View Matrix')
	$refresh = "rcm_matrix.php?do=viewmatrix&type=pages&id={$_REQUEST['id']}";

include "global.php";
$cp->header();
$links = '<a href="pages.php?do=add_page">Add Page</a> | '
		.'<a href="pages.php">Manage Pages</a>';

## MODULE HEADER
do_module_header('Page Manager', $links);

if ($_REQUEST['do'] == 'View Matrix') {
   echo "<br /><br /><center><b><h3>Loading content matrix...</h3></b></center>";
   }
if (empty($_REQUEST['do'])) {
   do_form_header('pages.php');
   do_table_header("Generic Content Pages");
   $result = $db->Execute("SELECT id,title FROM `Obsedb_pages`");
   while ($row = $result->FetchNextObject()) {
      $bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");
      echo '<tr>
            <td bgcolor="'.$bgcolor.'"><input type="radio" name="id" value="'.$row->ID.'"> '.$row->TITLE.'</td>
           </tr>';

   }
   echo '<tr>
         <td colspan="2">
            <input type="submit" name="do" value="Edit Page">
            <input type="submit" name="do" value="Delete Page">
            <input type="submit" name="do" value="View Matrix">
         </td>
        </tr>';
   do_table_footer();
   echo '</form>';

}

if ($_REQUEST['do'] == 'add_page') {

   do_form_header('pages.php');
   do_table_header('Add Page');
   do_text_row('Page Title','title');
   do_table_footer();
   do_table_header('Page Content');
   do_textarea_row('','content');
   do_submit_row("Continue");
   do_table_footer();
   echo '<input type="hidden" name="do" value="add_page_confirm">';
   echo '</form>';
   }



if ($_REQUEST['do'] == 'Edit Page') {
   $menuitem = $db->Execute("SELECT * FROM `Obsedb_pages` WHERE `id` = '$_REQUEST[id]'");
   do_form_header('pages.php');
   do_table_header('Edit Page');
   do_text_row('Page Title','title',clean($menuitem->fields['title']));
   do_table_footer();
   do_table_header('Page Content');
   do_textarea_row('','content',stripslashes($menuitem->fields['content']));
   do_submit_row('Continue');
   do_table_footer();
   echo '<input type="hidden" name="id" value="'.$menuitem->fields['id'].'">';
   echo '<input type="hidden" name="do" value="edit_page_confirm">';
   echo '</form>';
   }

if ($_REQUEST['do'] == 'add_page_confirm') {

   $rs = $db->Execute("SELECT * FROM `Obsedb_pages` WHERE `id` = '-1'");
   $record = array(
      'title' => $_REQUEST['title'],
      'content' => $_REQUEST['content']
      );

   $sql = $db->GetInsertSQL($rs, $record);
   $db->Execute($sql);
   echo '<center>Page has been successfully added, <a href="pages.php">click here to continue</a>.</center>';
   }

if ($_REQUEST['do'] == 'edit_page_confirm') {

   $rs = $db->Execute("SELECT * FROM `Obsedb_pages` WHERE `id` = '$_REQUEST[id]'");
   $record = array(
      'title' => $_REQUEST['title'],
      'content' => $_REQUEST['content']
      );

   $sql = $db->GetUpdateSQL($rs, $record);
   $db->Execute($sql);
   echo '<center>Page has been successfully updated, <a href="pages.php">click here to continue</a>.</center>';
   }

if ($_REQUEST['do'] == 'Delete Page') {

   $db->Execute("DELETE FROM `Obsedb_pages` WHERE `id` = '$_REQUEST[id]'");
   echo '<center>Page has been successfully removed, <a href="pages.php">click here to continue</a>.</center>';

   }

$cp->footer();
?>