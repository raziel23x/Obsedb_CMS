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

// Set NavBar
$location .= " > <b>Reviews</b>";

require_once("global.php");
require_once("templates/review_module.php");

$title .= " > Reviews";

if (empty($_REQUEST['do'])) {

   // ALPHA NAV BOX

   $alpha = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
   foreach ($alpha AS $key => $value) {
      $alphanav .= require("templates/reviews_alphabit.inc.php");
   }
   // END ALPHA NAV BOX
   $sections = array();
   $sql = $db->Execute("SELECT * FROM `Obsedb_reviews_sections` ORDER BY `title`");
   while ($row = $sql->FetchNextObject()) {
      $sections["$row->ID"] = stripslashes($row->TITLE);
   }
   if (isset($_REQUEST['browse'])) {
      $sql = $db->Execute("SELECT id,title,section FROM `Obsedb_reviews`
      WHERE `title` LIKE '".$_REQUEST['browse']."%'
      ORDER BY `title`");
   } else {
      $sql = $db->Execute("SELECT id,title,section FROM `Obsedb_reviews` ORDER BY `id` DESC LIMIT 15");
   }
   while ($row = $sql->FetchNextObject()) {
      $title = stripslashes($row->TITLE);
      $id = $row->ID;
      $section = stripslashes($sections["$row->SECTION"]);
      $review_rows .= include("templates/reviews_row.inc.php");
   }

   require_once("templates/reviews_main.inc.php");



   do_footer();
}

if ( $_REQUEST['do'] == 'view' ) {
   do_header();
   $review = $db->Execute("
   	SELECT *
   	FROM `Obsedb_reviews`
   	WHERE
   		Obsedb_reviews.id = '{$_REQUEST['id']}';");
   		

   include "templates/review_article.inc.php";
   build_matrix('reviews',$review->fields['id']);
   do_footer();

}
?>