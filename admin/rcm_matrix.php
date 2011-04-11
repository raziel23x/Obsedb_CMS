<?php

error_reporting(E_ALL ^ E_NOTICE);

include "global.php";
include "../sources/adminMatrixClass.php";

$cp->header();

$links = '<a href="rcm_matrix.php?do=search">Search</a>';
do_module_header('Relational Content Matrix',$links);


switch ($_REQUEST['do']) {
   case 'search':
      search_content();
      break;
   case 'search2':
      search2();
      break;
   case 'viewmatrix':
      viewmatrix();
      break;
   case 'create':
      create_new();
      break;
   case 'create2':
      create_confirm();
      break;
   case 'delete_resource':
      delete_resource();
      break;
   }

function viewmatrix() {
   global $db;
   do_form_header('rcm_matrix.php');

   generate_matrix($_REQUEST['type']);

   }

function create_new() {
   global $db;
   do_form_header('rcm_matrix.php');
   do_table_header('Create New Relational Link');

   if ($_REQUEST['reltype'] == 'news') {
      do_news_row();
      }
   if ($_REQUEST['reltype'] == 'Mods') {
      do_Mods_row();
      }
   if ($_REQUEST['reltype'] == 'pages') {
      do_pages_row();
      }
   if ($_REQUEST['reltype'] == 'reviews') {
      do_reviews_row();
      }
   if ($_REQUEST['reltype'] == 'previews') {
      do_previews_row();
      }
   if ($_REQUEST['reltype'] == 'companies') {
      do_companies_row();
      }
   if ($_REQUEST['reltype'] == 'screenshots') {
      do_screenshots_row();
      }
   do_submit_row('Create Relational Link');
   do_table_footer();
   echo '<input type="hidden" name="do" value="create2">';
   echo '<input type="hidden" name="type" value="', $_REQUEST['type'], '">';
   echo '<input type="hidden" name="id" value="', $_REQUEST['id'], '">';
   echo '<input type="hidden" name="reltype" value="', $_REQUEST['reltype'], '">';
   echo '</form>';
   }

function delete_resource() {
   global $db;
   $db->Execute("DELETE FROM `Obsedb_matrix` WHERE `id` = '$_REQUEST[did]'");
   viewmatrix();
   }

function create_confirm() {
   global $db;
   $rs = $db->Execute("SELECT * FROM `Obsedb_matrix` WHERE `id` = '-1'");
   $record = array(
      'cid' => $_REQUEST['id'],
      'ctype' => $_REQUEST['type'],
      'reltype' => $_REQUEST['reltype'],
      'relid' => $_REQUEST['relid']
      );
   $sql = $db->GetInsertSQL($rs, $record);
   $db->Execute($sql);
   echo '<center>Content link has been created, <a href="rcm_matrix.php?do=viewmatrix&type=', $_REQUEST['type'], '&id=', $_REQUEST['id'], '">click here to continue</a>.';
   }


function search_content() {
   global $db;
   do_form_header('rcm_matrix.php');
   do_table_header('Search Content');
   do_text_row('Keywords','keywords');
   echo '<tr>
   		<td class="formlabel" align="right"><b>Content Type</b></td>
   		<td class="formlabel"><select name="type">'
   . '<option value="null"> - </option>'
   . '<option value="companies">&nbsp; Companies</option>'
   . '<option value="Mods">&nbsp; Mods</option>'
   . '<option value="news">&nbsp; News</option>'
   . '<option value="pages">&nbsp; Pages</option>'
   . '<option value="previews">&nbsp; Previews</option>'
   . '<option value="reviews">&nbsp; Reviews</option>'
   . '</select></td></tr>';
   do_submit_row('Begin Search');
   do_table_footer();
   echo '<input type="hidden" name="do" value="search2">';
   echo '</form>';
   }

function search2() {
   global $db;

   do_table_header('Search results for "<i>'.stripslashes($_REQUEST['keywords']).'</i>"');
   switch ($_REQUEST['type']) {
      case 'null':
         die('Error: You must select a type of content to search.');
         break;
      case 'companies':
         $result = $db->Execute("SELECT * FROM `Obsedb_companies` WHERE `title` LIKE '$_REQUEST[keywords]%' ORDER BY `title`");
         while ($row = $result->FetchNextObject()) {
            echo "<tr><td><a href=\"rcm_matrix.php?type=company&do=viewmatrix&id=$row->ID\">" . stripslashes($row->TITLE) . " (View Matrix)</a></td></tr>";
         }
         break;
      case 'Mods':
         $result = $db->Execute("SELECT * FROM `Obsedb_Mods` WHERE `title` LIKE '$_REQUEST[keywords]%' ORDER BY `title`");
         while ($row = $result->FetchNextObject()) {
            echo "<tr><td><a href=\"rcm_matrix.php?type=Mods&do=viewmatrix&id=$row->ID\">" . stripslashes($row->TITLE) . " (View Matrix)</a></td></tr>";
         }
         break;
      case 'links':
         $result = $db->Execute("SELECT * FROM `Obsedb_links` WHERE `title` LIKE '$_REQUEST[keywords]%' ORDER BY `title`");
         while ($row = $result->FetchNextObject()) {
            echo "<tr><td><a href=\"rcm_matrix.php?type=links&do=viewmatrix&id=$row->ID\">" . stripslashes($row->TITLE) . " (View Matrix)</a></td></tr>";
         }
         break;
      case 'news':
         $result = $db->Execute("SELECT * FROM `Obsedb_news` WHERE `title` LIKE '$_REQUEST[keywords]%' ORDER BY `title`");
         while ($row = $result->FetchNextObject()) {
            echo "<tr><td><a href=\"rcm_matrix.php?type=news&do=viewmatrix&id=$row->ID\">" . stripslashes($row->TITLE) . " (View Matrix)</a></td></tr>";
         }
         break;
      case 'previews':
         $result = $db->Execute("SELECT * FROM `Obsedb_previews` WHERE `title` LIKE '$_REQUEST[keywords]%' ORDER BY `title`");
         while ($row = $result->FetchNextObject()) {
            echo "<tr><td><a href=\"rcm_matrix.php?type=previews&do=viewmatrix&id=$row->ID\">" . stripslashes($row->TITLE) . " (View Matrix)</a></td></tr>";
         }
         break;
      case 'reviews':
         $result = $db->Execute("SELECT * FROM `Obsedb_reviews` WHERE `title` LIKE '$_REQUEST[keywords]%' ORDER BY `title`");
         while ($row = $result->FetchNextObject()) {
            echo "<tr><td><a href=\"rcm_matrix.php?type=reviews&do=viewmatrix&id=$row->ID\">" . stripslashes($row->TITLE) . " (View Matrix)</a></td></tr>";
         }
         break;
      case 'pages':
         $result = $db->Execute("SELECT * FROM `Obsedb_pages` WHERE `title` LIKE '$_REQUEST[keywords]%' ORDER BY `title`");
         while ($row = $result->FetchNextObject()) {
            echo "<tr><td><a href=\"rcm_matrix.php?type=pages&do=viewmatrix&id=$row->ID\">" . stripslashes($row->TITLE) . " (View Matrix)</a></td></tr>";
         }
         break;
      }
   do_table_footer();
   }
?>