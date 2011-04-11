<?php
/*
##############################################################
 Sector Portal Content Management System
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

$location .= " > <b>Mods</b>";

require_once("global.php");

if (empty($_REQUEST['do'])) {

   $sql = "SELECT `id`,`title`,`section`,`genre`,`developer`,`publisher`,`release_date` FROM `Obsedb_Mods` ";

   if (!empty($_REQUEST['title'])) {

      $sql .= "WHERE `title` LIKE '$_REQUEST[title]%' ";

      if (!empty($_REQUEST['section'])) {

         $sql .= " AND `section` = '$_REQUEST[section]' ";

      }

      $sql .= " AND `published` = '1' ";

   } else {

      if (!empty($_REQUEST['section'])) {

        $sql .= "WHERE `section` = '$_REQUEST[section]' AND `published` = '1' ";

      } else {

      	$sql .= "WHERE `published` = '1' ";

      }
   }

   if (isset($_REQUEST[order])) {
      $sql .= " ORDER BY `$_REQUEST[order]` ";
   } else {
      $sql .= " ORDER BY `title` ";
   }

   switch($_REQUEST['sort']) {

      case 'asc':
         $sql .= " ASC ";
         break;
      case 'desc':
         $sql .= " DESC ";
         break;
      default:
         $sql .= " ASC ";
         break;
   }

   if ($sql == "SELECT `id`,`title`,`section`,`genre`,`developer`,`publisher`,`release_date` FROM `Obsedb_Mods` WHERE `published` = '1' ORDER BY `title` ASC") {

      $sql .= " LIMIT 0,20 ";

   }

   $sections = array();
   $sql2 = $db->Execute("SELECT * FROM `Obsedb_Mods_sections` ORDER BY `title`");
   while ($srow = $sql2->FetchNextObject()) {
      $sections["$srow->ID"] = stripslashes($srow->TITLE);
   }

   $specialdata = "<b>Mod Sections</b><br />";
   foreach ($sections AS $key => $value) {
      $specialdata .= "&nbsp;<a href=\"Mods.php?section=$key\">$value</a><br />";
   }
   $specialdata .= "<br />";

   $companies = array();
   $company_sql = $db->Execute("SELECT * FROM `Obsedb_companies` ORDER BY `title`");
   while ($crow = $company_sql->FetchNextObject()) {
      $companies["$crow->ID"] = stripslashes($crow->TITLE);
   }

   do_header();

   switch ($_REQUEST['sort']) {
      case 'asc':
         $arrowlink = '<a href="Mods.php?sort=desc&section='.$_REQUEST[section].'&order='.$_REQUEST[order].'"><img src="images/arrow-down.png" border="0"></a>';
         break;
      case 'desc':
         $arrowlink = '<a href="Mods.php?sort=asc&section='.$_REQUEST[section].'&order='.$_REQUEST[order].'"><img src="images/arrow-up.png" border="0"></a>';
         break;
      default:
         $arrowlink = '<a href="Mods.php?sort=desc&section='.$_REQUEST[section].'&order='.$_REQUEST[order].'"><img src="images/arrow-down.png" border="0"></a>';
         break;
   }

   if ($_REQUEST['order'] == 'title') {
      $label_title = 'Title ' . $arrowlink;
   } else {
      $label_title = '<a href="Mods.php?order=title&section='.$_REQUEST[section].'&sort='.$_REQUEST[sort].'">Title</a>';
   }

   if ($_REQUEST['order'] == 'genre') {
      $label_genre = 'Genre ' . $arrowlink;
   } else {
      $label_genre = '<a href="Mods.php?order=genre&section='.$_REQUEST[section].'&sort='.$_REQUEST[sort].'">Genre</a>';
   }

   if ($_REQUEST['order'] == 'publisher') {
      $label_publisher = 'Publisher ' . $arrowlink;
   } else {
      $label_publisher = '<a href="Mods.php?order=publisher&section='.$_REQUEST[section].'&sort='.$_REQUEST[sort].'">Publisher</a>';
   }

   if ($_REQUEST['order'] == 'developer') {
      $label_developer = 'Developer ' . $arrowlink;
   } else {
      $label_developer = '<a href="Mods.php?order=developer&section='.$_REQUEST[section].'&sort='.$_REQUEST[sort].'">Developer</a>';
   }

   if ($_REQUEST['order'] == 'release_date') {
      $label_release = 'Release Date ' . $arrowlink;
   } else {
      $label_release = '<a href="Mods.php?order=release_date&section='.$_REQUEST[section].'&sort='.$_REQUEST[sort].'">Release Date</a>';
   }

   if ($_REQUEST['order'] == 'section') {
      $label_section = 'Platform ' . $arrowlink;
   } else {
      $label_section = '<a href="Mods.php?order=section&section='.$_REQUEST[section].'&sort='.$_REQUEST[sort].'">Platform</a>';
   }
    $Modlist_header = new Template;
    $Modlist_header->open_template( 'Modlist_header' );
    $Modlist_header->addvar( '{title}', $label_title );
    $Modlist_header->addvar( '{genre}', $label_genre );
    $Modlist_header->addvar( '{release}', $label_release );
    $Modlist_header->addvar( '{section}', $label_section );
    $Modlist_header->parse_template();
    $Modlist_header->print_template();
    unset($Modlist_header);

    $Modlist_row = new Template;
    $Modlist_row->open_template( 'Modlist_row' );
    

   $result = $db->Execute($sql) or die($db->ErrorMsg());
   while ($row = $result->FetchNextObject()) 
   {
        $bgcolor = ($bgcolor == "#FFFFFF" ? "#E9E9E9" : "#FFFFFF");
        $section = stripslashes($sections["$row->SECTION"]);
        $publisher = stripslashes($companies["$row->PUBLISHER"]);
        $developer = stripslashes($companies["$row->DEVELOPER"]);
        $Modlist_row->addvar( '{id}', $row->ID );
        $Modlist_row->addvar( '{title}', stripslashes($row->TITLE) );
        $Modlist_row->addvar( '{bgcolor}', $bgcolor );
        $Modlist_row->addvar( '{section}', $section );
        $Modlist_row->addvar( '{genre}', stripslashes($row->GENRE) );
        $Modlist_row->addvar( '{release}', stripslashes($row->RELEASE_DATE) );
        $Modlist_row->parse_template();
        $Modlist_row->print_template();
    }
    unset($Modlist_row);

    $Modlist_footer = new Template;
    $Modlist_footer->open_template( 'Modlist_footer' );
    $Modlist_footer->print_template();
    unset($Modlist_footer);
    
   

   do_footer();

   }

?>
