<?php

// Template Information
// ======================================================================
// This template is used to lay out your front page in any way you want.
// By including different files (index_newsbit, index_Modbit, etc) the
// system loads the contents of those files in that order. As such, if
// you dont want a certain entity to appear on your front page, remove it
// from this file.
// ======================================================================

?>

		 <?php include("templates/index_newsbit.inc.php"); ?>
			<div class="alt2">
			<div class='alt2_top'>
			<img src='images/corners/alt2_tlc.gif' width='10' height='10' class='corner' style='display: none;'>
			</div>
			<p align="center">
				<b><a href="archive.php">News Archive</a></b>
			</p>
			<div class='alt2_bottom'>
			<img src='images/corners/alt2_blc.gif' width='10' height='10' class='corner' style='display: none;'>
			</div>
			</div>
         <br />



         <div class="alt1">
         <div class='alt1_top'><img src='images/corners/alt1_tlc.gif' width='10' height='10' class='corner' style='display: none;'></div>
		 <p>
         <table border='0' cellspacing='0' cellpadding='0' width='100%'>
         <tr>
         <td width='50%' valign='top'>
         <?php include("sources/frontpage_objects/popularMods.php"); ?>
		 </td>
		 <td width='50%' valign='top'>
         <?php include("sources/frontpage_objects/latestMods.php"); ?>
         </td>
         </tr>
         </table><br />

         </p>
		 	<div class='alt1_bottom'><img src='images/corners/alt1_blc.gif' width='10' height='10' class='corner' style='display: none;'></div>
         </div><br />
			<div class="alt2">
			<div class='alt2_top'>
			<img src='images/corners/alt2_tlc.gif' width='10' height='10' class='corner' style='display: none;'>
			</div>
			<p align="center">
			<strong>
				<a href="Mods.php">Browse Mods</a> |
				<a href="search.php">Search Mods</a>
			</strong>
			</p>
			<div class='alt2_bottom'>
			<img src='images/corners/alt2_blc.gif' width='10' height='10' class='corner' style='display: none;'>
			</div>
			</div>
         <br />


         <div class="alt1">
         <div class='alt1_top'><img src='images/corners/alt1_tlc.gif' width='10' height='10' class='corner' style='display: none;'></div>
		 <p>
         <table border='0' cellspacing='0' cellpadding='0' width='100%'>
         <tr>
         <td width='50%' valign='top' style="padding-left: 10px;">
         <?php include("templates/index_reviewbit.inc.php"); ?>
		 </td>
		 <td width='50%' valign='top' style="padding-right: 10px;">
         <?php include("templates/index_previewbit.inc.php"); ?>
         </td>
         </tr>
         </table>
         </p>
		 	<div class='alt1_bottom'><img src='images/corners/alt1_blc.gif' width='10' height='10' class='corner' style='display: none;'></div>
         </div><br />
