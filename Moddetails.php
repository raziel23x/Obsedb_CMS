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

error_reporting(E_ALL & ~E_NOTICE);
@set_magic_quotes_runtime(0);

$location .= " > <a href=\"Mods.php\">Mods</a> > <b>Mod Info</b>";


require_once("global.php");
$id = mysql_real_escape_string($_REQUEST['id']);

// Get Mod Info
if (isset($id)) {
   $result = $db->Execute("SELECT * FROM `Obsedb_Mods` WHERE `id` = '$id' LIMIT 1");
   while ($row = $result->FetchNextObject()) {

      if (!empty($row->DEVELOPER))
      {
         $dev = $db->Execute("SELECT * FROM `Obsedb_companies` WHERE `id` = '$row->DEVELOPER' LIMIT 1");
         $developer_link = "<a href=\"companies.php?do=view&id=".$dev->fields['id']."\">".stripslashes($dev->fields['title'])."</a>";
      }

      if (!empty($row->PUBLISHER))
      {
         $pub = $db->Execute("SELECT * FROM `Obsedb_companies` WHERE `id` = '$row->PUBLISHER' LIMIT 1");
         $publisher_link = "<a href=\"companies.php?do=view&id=".$pub->fields['id']."\">".stripslashes($pub->fields['title'])."</a>";
      }

      if (!empty($row->SECTION))
      {
         $section = $db->Execute("SELECT * FROM `Obsedb_Mods_sections` WHERE `id` = '$row->SECTION' LIMIT 1");
         $platform = stripslashes($section->fields['title']);
      }


	$cheats = $db->Execute("SELECT id,Modid FROM `Obsedb_cheats` WHERE Modid = $id LIMIT 1");
	if ($cheats->RecordCount() >= 1)
	{
		$cheat_link = "<a href=\"cheats.php?id=$row->ID\">Cheats</a>";
	} else {
		$cheat_link = "Cheats";
	}

	$downloads = $db->Execute("SELECT * FROM Obsedb_downloads WHERE Modid = $id LIMIT 1;") or die($db->ErrorMsg());
	if ($downloads->RecordCount() > 0)
	{
		$download_link = "<a href=\"downloads.php?id=$row->ID\">Downloads</a>";
	} else {
		$download_link = "Downloads";
	}

$getfields = $db->Execute("SELECT * FROM Obsedb_customfields WHERE module = 'Mods' ORDER BY title");
while ($field = $getfields->FetchNextObject())
{
   $getvalue = $db->Execute("SELECT * FROM Obsedb_Mods_customdata WHERE Modid = $id AND fieldid = $field->ID;");

   if ($getvalue->fields['value'] != '')
   {
   $customfields .= "<tr><td><b>";
   $customfields .= stripslashes($field->TITLE) . "</b>: ";
   $customfields .= stripslashes($getvalue->fields['value']) . "</td></tr>";
   }
}


      do_header();
      
      $Mod = new Template;
      $Mod->open_template( 'Mod_profile' );
      $Mod->addvar( '{title}', stripslashes($row->TITLE) );
      $Mod->addvar( '{id}', $row->ID );
      $Mod->addvar( '{cheat_link}', $cheat_link );
      $Mod->addvar( '{download_link}', $download_link );
      if (!empty($row->BOXSHOT)) {
        $Mod->addvar( '{boxshot}', '<img src="'.$row->BOXSHOT.'">' ); } else {
        $Mod->addvar( '{boxshot}', 'No Boxshot' ); }
      $Mod->addvar( '{developer}', $developer_link );
      $Mod->addvar( '{publisher}', $publisher_link );
      $Mod->addvar( '{genre}', stripslashes($row->GENRE) );
      $Mod->addvar( '{release}', stripslashes($row->RELEASE_DATE) );
      $Mod->addvar( '{multiplayer}', stripslashes($row->MULTIPLAYER) );
      $Mod->addvar( '{custom_fields}', $customfields );
      $Mod->addvar( '{platform}', $platform );
      $Mod->addvar( '{system}', stripslashes($row->REQ_SYSTEM) );
      $Mod->addvar( '{ram}', stripslashes($row->REQ_RAM) );
      $Mod->addvar( '{video}', stripslashes($row->REQ_VIDEO) );
      $Mod->addvar( '{space}', stripslashes($row->REQ_SPACE) );
      $Mod->addvar( '{mouse}', stripslashes($row->REQ_MOUSE) );
      $Mod->addvar( '{directx}', stripslashes($row->REQ_DIRECTX) );
      $Mod->addvar( '{sound}', stripslashes($row->REQ_SOUND) );
      $Mod->addvar( '{description}', clean($row->DESCRIPTION) );
	  $Mod->addvar( '{views}', stripslashes($row->VIEWS) );
      
      $Mod->parse_template();
      $Mod->print_template();
      build_matrix('Mods',$row->ID);
      
      
      if ($userinfo[id] == '0')
      {
      	print "Please log in to post comments.<br />";
      	require_once("templates/login_form.inc.php");
      } else {
      	require_once("templates/Mods_postcomment.inc.php");
      }
      $result = $db->Execute("SELECT id,Mod_id,username,date,comment FROM Obsedb_Mods_comments WHERE Mod_id = '$id' ORDER BY DATE_FORMAT(date,'%y%c%d%H%i%s')");
	  $x=1;
	  while ($row = $result->FetchNextObject())
	  {
	  	$row->DATE = strtotime($row->DATE);
	  	$row->DATE = date('M jS, Y  g:i a', $row->DATE);
	  	if ($x == 1)
	  	{
	  		print("
	  		<div style=\"padding: 10px; background: #f5f5f5;\">
	  		by <b>$row->USERNAME</b> on $row->DATE<br />
	  		<font style='font-size: 10pt;line-height: 150%;'>$row->COMMENT</font></div>");
	  		$x = 0;
	  	} else {
	  		print("
	  		<div style='padding: 10px;'>
	  		by <b>$row->USERNAME</b> on $row->DATE<br />
	  		<font style='font-size: 10pt;line-height: 150%;'>$row->COMMENT</font></div>");
	  		$x++;
	  	}
	  }
      do_footer();
      $views2=($row->VIEWS+1);
      $db->Execute("UPDATE `Obsedb_Mods` SET `views` = '$views2' WHERE `id` = '$id'");  
   }
} else {
   do_header();
   echo "<b>System Error Message</b><br />";
   echo "You cannot access this page directly, please go back and select a Mod.<br />";
   echo "If the problem persists, please contact the webmaster.";
   do_footer();
}
?>