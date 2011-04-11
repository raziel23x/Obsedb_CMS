<?php

/*
##############################################################
 Obsedb CMS Content Management System
 Copyright (C) 2009  Gerald Wayne Baggett Jr

 This program is free software; you can redistribute it and/or modify
 it under the terms of the BSD License as published by
 the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 BSD License for more details.

 
##############################################################
*/

// Set error reporting
error_reporting(E_ALL ^ E_NOTICE);

// Set auto-redirect switches
switch ($_REQUEST['do'])
{
	case 'add_confirm':
		$refresh = "screenshots.php";
		break;
	//case 'Delete Screenshot':
		//$refresh = "screenshots.php";
		//break;
	case 'edit_confirm':
		$refresh = "screenshots.php";
		break;
}

// Get required files
require_once( 'global.php' );
require_once( '../sources/userScreenshotsClass.php' );

// Print control panel header
$cp->header();

// Create module object
$module = new Module;

// Print module header
$module->header();

// Backwards compatability fix
$_REQUEST['s'] = $_REQUEST['Modid'];


if ( !isset( $_REQUEST['do'] ) ) 
{
    // ==============================
    // Screenshot Manager Main Page
    // ==============================
    
    // Get list of sections (Mods)
    $sections = $db->Execute("SELECT g.id,g.title,p.title AS `platform` FROM `Obsedb_Mods` AS g, `Obsedb_Mods_sections` AS p WHERE g.section = p.id ORDER BY g.title ASC, g.section ASC");
    $spSections = array();
    
    // Fill array with results
    while ( $row = $sections->FetchNextObject() ) 
    {
        $id = $row->ID;
        $title = stripslashes( $row->TITLE );
        $platform = stripslashes( $row->PLATFORM );
        if ($row->PLATFORM == '')
        {
            $platform = "None";
        }
        
        $spSections["$id"] = "$title ($platform)";
    }
   
    // SELECT Mod FORM 
    do_form_header( 'screenshots.php' );
    do_table_header( 'View screenshots by Mod' );
    do_Mod_select_row();
    do_submit_row( 'Submit' );
    do_table_footer();
    do_form_footer();
   
    // SELECT SCREENSHOT FORM
    do_form_header( 'screenshots.php' );
    do_table_header( 'Screenshots' );
   
    // Check to see if a Mod ID is specified
    if (isset($_REQUEST['Modid'])) 
    {
        // Get screenshots for this Mod
        do_blank_row("Search Results");
        $result = $db->Execute("
            SELECT id,title,section 
            FROM `Obsedb_screenshots` 
            WHERE `section` = '$_REQUEST[Modid]' 
            ORDER BY `id` DESC");
    } else {
        // Get the latest 30 screenshots
        do_blank_row("Latest Screenshots");
        $result = $db->Execute("
            SELECT s.id AS id,s.title AS title,s.section AS section,g.title AS Mod 
            FROM `Obsedb_screenshots` AS s, `Obsedb_Mods` AS g 
            WHERE s.section = g.id 
            ORDER BY `id` DESC LIMIT 30");
    }
   

    echo "<tr><td class=\"formlabel\" colspan=\"2\"><select name=\"id\" size=\"15\">";
    while ($row = $result->FetchNextObject()) {
      $bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");
      echo "<option value=\"$row->ID\">" . stripslashes($row->TITLE) . " | " . $spSections["$row->SECTION"] . " </option>";

      }
   echo "</select></td></tr>";

   echo '<tr>
         <td colspan="2">
            <input type="submit" name="do" value="Edit Screenshot">
            <input type="submit" name="do" value="Delete Screenshot">
            <input type="submit" name="do" value="View Matrix">
         </td>
        </tr>';
   do_table_footer();
   echo '</form>';


   }

if ($_REQUEST['do'] == 'add_screenshot') {
   $sections = $db->Execute("SELECT g.id,g.title,p.title AS `platform` FROM `Obsedb_Mods` AS g, `Obsedb_Mods_sections` AS p WHERE g.section = p.id ORDER BY g.title");
   $spSections = array();
   while ($row = $sections->FetchNextObject()) {
      $spSections["$row->ID"] = $row->TITLE . " ($row->PLATFORM)";
      }
   
   if ($spconfig['screenshots_upload'] == '1')
   {
       print '<form method="post" action="screenshots.php" enctype="multipart/form-data">';
       do_table_header( 'Upload Screenshot' );
       do_text_row('Title','title');
       do_Mod_select_row();
       print "<tr><td class=\"formlabel\" align=\"right\"><b>File</b></td>";
       print "<td class=\"formlabel\"><input type=\"file\" name=\"image\"></td></tr>";
       do_submit_row( 'Upload' );
       do_table_footer();
       print '<input type="hidden" name="do" value="upload">';
       do_form_footer();
   }
   
   $formdata = array(
      'title' => array(
         'type' => 'text',
         'title' => 'Title',
         'name' => 'title'),

     'section' => array(
        'type' => 'select',
        'title' => 'Mod',
        'name' => 'section',
        'value' => $spSections),

      'thumb' => array(
         'type' => 'text',
         'title' => 'Thumbnail URL',
         'name' => 'thumb'),

      'screen' => array(
         'type' => 'text',
         'title' => 'Screenshot URL',
         'name' => 'screen'),

      'submit' => array(
         'type' => 'submit',
         'title' => 'Add Screenshot')
      );
   GenerateForm('screenshots.php','Add Screenshot','add_confirm',$formdata);
   do_form_footer();
   
    if ( $spconfig['screenshots_upload'] == '0' )
    {
        do_table_header();
        do_blank_row("The screenshot upload feature is currently turned off.");
        do_table_footer();
    }
    
    if ( $spconfig['screenshots_thumbnailing'] == '0' )
    {
        do_table_header();
        do_blank_row("The auto-thumbnailing feature is currently turned off.");
        do_table_footer();
    }

   }

if ($_REQUEST['do'] == 'Edit Screenshot') {

   $result = $db->Execute("
      SELECT
         Obsedb_screenshots.id, Obsedb_screenshots.title, Obsedb_screenshots.section, Obsedb_screenshots.thumb, Obsedb_screenshots.screen
      FROM
         Obsedb_screenshots
      WHERE
         Obsedb_screenshots.id = $_REQUEST[id]");
   $sections = FetchSections('Obsedb_screenshots_sections');

   foreach($sections AS $key => $value) {
      if ($key == $result->fields['section']) { $selected = "selected"; }
      $sectionoptions .= "<option value=\"$key\" $selected>" . stripslashes($value) . "</option>";
      $selected = "";
   }
   $formdata = array(
      'title' => array(
         'type' => 'text',
         'title' => 'Title:',
         'name' => 'title',
         'value' => $result->fields['title']),

     'section' => array(
        'type' => 'text',
        'title' => 'Section',
        'name' => 'section',
        'value' => $result->fields['section']),

      'thumb' => array(
         'type' => 'text',
         'title' => 'Thumbnail URL',
         'name' => 'thumb',
         'value' => $result->fields['thumb']),

      'screen' => array(
         'type' => 'text',
         'title' => 'Screenshot URL',
         'name' => 'screen',
         'value' => $result->fields['screen']),

      'submit' => array(
         'type' => 'submit',
         'title' => 'Save Screenshot')
      );
   $hiddendata = array('id' => $_REQUEST[id]);
   GenerateForm('screenshots.php','Edit Screenshot','edit_confirm',$formdata,$hiddendata);
   
   do_table_header( 'More Options' );
   do_blank_row( "<a href=\"screenshots.php?do=Delete Screenshot&id=$_REQUEST[id]\">Delete Screenshot</a>" );
   do_blank_row( "<a href=\"screenshots.php\">Cancel & return to screenshot manager</a>");
   do_table_footer();
   }


if ($_REQUEST['do'] == 'add_confirm') {

   $RS = $db->Execute("
      SELECT Obsedb_screenshots.id, Obsedb_screenshots.title, Obsedb_screenshots.thumb, Obsedb_screenshots.screen,
      Obsedb_screenshots.section
      FROM `Obsedb_screenshots`
      WHERE Obsedb_screenshots.id = '0'");
   $record = array(
      'title' => $_REQUEST['title'],
      'thumb' => $_REQUEST['thumb'],
      'screen' => $_REQUEST['screen'],
      'section' => $_REQUEST['section']);
   $sql = $db->GetInsertSQL($RS, $record);
   $db->Execute($sql);
   echo '<a href="screenshots.php">Click Here to Continue</a>';
   }

if ($_REQUEST['do'] == 'edit_confirm') {

   $RS = $db->Execute("
      SELECT Obsedb_screenshots.id, Obsedb_screenshots.title, Obsedb_screenshots.thumb, Obsedb_screenshots.screen,
      Obsedb_screenshots.section
      FROM `Obsedb_screenshots`
      WHERE Obsedb_screenshots.id = '$_REQUEST[id]'");
   $record = array(
      'title' => $_REQUEST['title'],
      'thumb' => $_REQUEST['thumb'],
      'screen' => $_REQUEST['screen'],
      'section' => $_REQUEST['section']);
   $sql = $db->GetUpdateSQL($RS, $record);
   $db->Execute($sql);
   echo '<a href="screenshots.php">Click Here to Continue</a>';
   }

if ($_REQUEST['do'] == 'Delete Screenshot') {

    $result = $db->Execute("
        SELECT * FROM Obsedb_screenshots 
        WHERE `id` = '$_REQUEST[id]'");
        
    $path = $PATH_TRANSLATED;
    $path = str_replace( "/user/screenshots.php", "/", $path );
    unlink( $path . $result->fields['thumb']);
    unlink( $path . $result->fields['screen']);

   $db->Execute("DELETE FROM `Obsedb_screenshots` WHERE `id` = '$_REQUEST[id]'");
   SPMessage("Screenshot has been removed.");
   }
if ($_REQUEST['do'] == 'manage_sections') {

   do_form_header('screenshots.php');
   do_table_header('Sections');

   $sections = FetchSections('Obsedb_screenshots_sections');
   foreach($sections AS $key => $value) {

      $BGCOLOR = ($BGCOLOR == "#ECECFF" ? "#FFFFFF" : "#ECECFF");
      echo "<tr>
               <td bgcolor=\"$BGCOLOR\" colspan=\"2\">
                  <input type=\"radio\" value=\"$key\" name=\"id\">" . stripslashes($value) . "
               </td>
            </tr>";
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

   $db->Execute("DELETE FROM `Obsedb_screenshots_sections` WHERE `id` = '$_REQUEST[id]'");
   echo '<center>Section has been successfully removed, <a href="screenshots.php?do=manage_sections">click here to continue</a>.</center>';
   }

if ($_REQUEST['do'] == 'add_section') {

   do_form_header('screenshots.php');
   do_table_header("Add Section");
   do_text_row("Title","title");
   do_submit_row();
   echo '<input type="hidden" name="do" value="add_section_confirm">';
   do_table_footer();
   echo '</form>';

   }

if ($_REQUEST['do'] == 'Edit Section') {
   edit_section();

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


if ($_REQUEST['do'] == 'edit_section_confirm') {

	$module->edit_section_confirm();

   }

if ($_REQUEST['do'] == 'add_section_confirm') {

   $db->Execute("INSERT INTO `Obsedb_screenshots_sections` (title) VALUES ('$_REQUEST[title]');");
   echo '<center>Section has been successfully created, <a href="screenshots.php">click here to continue</a>.</center>';

   }
function do_Mod_select_row( $Modid = '' )
{
    global $db;
    $result = $db->Execute("SELECT g.id,g.title,p.title AS `platform` FROM Obsedb_Mods AS g, Obsedb_Mods_sections AS p WHERE g.section = p.id ORDER BY p.title ASC, g.title ASC");
    $Mods['0'] = 'None';
    while ($row = $result->FetchNextObject())
    {
        $Mods[$row->ID] = stripslashes($row->TITLE) . " (" . stripslashes($row->PLATFORM) . ")";
    }
    do_select_row("Mod","Modid",$Mods,$Modid);
}
if ($_REQUEST['do'] == 'upload')
{
    $image = $_REQUEST["image"];
    do_table_header( 'Debug Information' );
    do_blank_row( "Image Name: " . $_FILES["image"]["name"] );
    do_blank_row( "Image Type: " . $_FILES["image"]["type"] );
    $aCurBasePath = dirname( $PATH_TRANSLATED );
    $aCurBasePath = str_replace( "/user", "/media/screenshots/", $aCurBasePath );
    do_blank_row( "Path:" . $aCurBasePath );
    do_table_footer();
    $errors = "";
    if ( !empty($image_name) ) 
    {
        if ( ( $image_type == "image/gif" ) ||
             ( $image_type == "image/pjpeg" ) ||
             ( $image_type == "image/jpeg" ) )
        {
            $image_name = str_replace( " ", "-", $image_name );
            $aNewName = $aCurBasePath . $_REQUEST['Modid'] . "_" . $image_name;
            
            
            copy( $_FILES["image"]["tmp_name"], $aNewName ) or die("Could not copy to $aNewName");
            
            if ( $spconfig['screenshots_thumbnailing'] == '1' )
            {
                $aNewName2 = $aCurBasePath . $_REQUEST['Modid'] . "_" . "thumb_" . $image_name;
                $thumbnail = imagecreatefromjpeg($aNewName);
                $width = imagesx( $thumbnail );
                $height = imagesy( $thumbnail );
                
                $new_width = 120;
                $new_height = floor( $height * ( 120 / $width ) );
                
                do_table_header("More Debug Information");
                do_blank_row("\$aNewName = $aNewName");
                do_blank_row("\$aNewName2 = $aNewName2");
                do_blank_row("\$width = $width");
                do_blank_row("\$height = $height");
                do_blank_row("\$new_width = $new_width");
                do_blank_row("\$new_height = $new_height");
               
                do_table_footer();
                
                $tmp_img = imagecreatetruecolor( $new_width, $new_height );
                imagecopyresized( $tmp_img, $thumbnail, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                imagejpeg( $tmp_img, $aNewName2 );
            } else {
                $aNewName2 = $aNewName;
            }
        }
    }
   $RS = $db->Execute("
      SELECT Obsedb_screenshots.id, Obsedb_screenshots.title, Obsedb_screenshots.thumb, Obsedb_screenshots.screen,
      Obsedb_screenshots.section
      FROM `Obsedb_screenshots`
      WHERE Obsedb_screenshots.id = '0'");
   $record = array(
      'title' => $_REQUEST['title'],
      'thumb' => "media/screenshots/".$_REQUEST['Modid']."_thumb_" . $image_name,
      'screen' => "media/screenshots/".$_REQUEST['Modid']."_" . $image_name,
      'section' => $_REQUEST['Modid']);
   $sql = $db->GetInsertSQL($RS, $record);
   $db->Execute($sql);
   SPMessage( "Screenshot has been successfully added." );
}

$cp->footer();
?>