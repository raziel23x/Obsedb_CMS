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

include "config.php";
include "sources/db/adodb.inc.php";
include "sources/functions.php";
include "sources/functions_menu.php";

$db = NewADOConnection('mysql');
$db->Connect($db_host,$db_user,$db_pass,$db_name);

$Obsedb = new Obsedb;
$Obsedb->buildConfig();

require_once("sources/authentication.php");
require_once("sources/templates.class.php");


$spconfig = array();
$Obsedb_configuration = $db->Execute("SELECT * FROM `Obsedb_configuration`");
while ($cfgdata = $Obsedb_configuration->FetchNextObject()) { $spconfig["$cfgdata->KEY"] = stripslashes($cfgdata->VALUE); }
$title = $spconfig['site_title'];

/* Sets whether or not user's browser actually fetches fresh content */
setCache(clean($Obsedb->config['true_refresh']));

function do_header()
{
    global $right, $top, $bottom, $location, $spconfig;
    global $latest_poll, $userinfo, $template;

    // Title of the web site
    $title = $spconfig["site_title"];

    // Meta tag description text
    $meta_description = $spconfig["meta_description"];

    // Meta tag keyword text
    $meta_keywords = $spconfig["meta_keywords"];

    // Create a new template object
    $template = new Template;

    // Open the template named "header" from the database
    $template->open_template( 'header' );
    
    $stylesheet = new Template;
    $stylesheet->open_template( 'stylesheet' );

    // Add the following variables to the template
    $template->addvar( '{title}', $title );
    $template->addvar( '{meta_description}', $meta_description );
    $template->addvar( '{meta_keywords}', $meta_keywords );
    $template->addvar( '{menu_top}', $top );
    $template->addvar( '{menu_left}', GenerateLeftMenu() );
    $template->addvar( '{menu_right}', GenerateRightMenu() );
    $template->addvar( '{menu_poll}', GenerateLatestPoll() );
    $template->addvar( '{stylesheet}', $stylesheet->template );

    // Create a new template object for the user login box
    $login_box = new Template;

    // Check to see if user is logged in
    if ( $userinfo['id'] == '0' )
    {
      $login_box->open_template( 'log_in_box' );
      $login_box->addvar( '{action}', $_SERVER['REQUEST_URI'] );
      $login_box->parse_template();
    } else {
      $login_box->open_template( 'logged_in_box' );
      $login_box->addvar( '{username}', $userinfo['username'] );
      $login_box->parse_template();
    }

    $template->addvar( '{login_box}', $login_box->parsed_template );

    // Parse the template with the variables we have added
    $template->parse_template();

    // Output the template
    $template->print_template();
}

function do_footer()
{
    global $bottom;

    $footer = new Template;
    $footer->open_template( 'footer' );
    $footer->addvar( '{bottom}', $bottom );
    $footer->parse_template();
    $footer->print_template();
}

// $top = '<font id="menutitle">'.$spconfig['topmenu_title'].'</font>';

$fetch_top = $db->Execute("SELECT * FROM `Obsedb_menu_items` WHERE `location` = 'top' AND `active` = '1' ORDER BY `ordering`");
$total_top = $fetch_top->RecordCount();
while ($row = $fetch_top->FetchNextObject())
{
	$counter++;
	if ($row->TARGET == '_blank')
	{
		$special = 'target="_blank"';
	}

	$top .= ' <a href="' . $row->URL . '">' . $row->TITLE . '</a> ';

	if ($counter < $total_top)
	{
		$top .= " | ";
	}

	$special = '';

}

$counter = 0;

// $bottom = '<font id="menutitle">'.$spconfig['bottommenu_title'].'</font>';
$fetch_bottom = $db->Execute("SELECT * FROM `Obsedb_menu_items` WHERE `location` = 'bottom' AND `active` = '1' ORDER BY `ordering`");
$total_bottom = $fetch_bottom->RecordCount();
while ($row = $fetch_bottom->FetchNextObject())
{
	$counter++;
	if ($row->TARGET == '_blank')
	{
		$special = "target=\"_blank\"";
	}

	$bottom .= ' <a href="' . $row->URL . '">' . stripslashes($row->TITLE) . '</a> ';

	if ($counter < $total_top)
	{
		$bottom .= " | ";
	}

	$special = '';
   }

// LATEST POLL

$PollResult = $db->Execute("SELECT * FROM `Obsedb_polls` ORDER BY `id` DESC LIMIT 1");
$latest_poll = "<b>" . $PollResult->fields['title'] . "</b><br />";

$PollOptions = $db->Execute("SELECT * FROM `Obsedb_polls_options` WHERE `poll_id` = '".$PollResult->fields['id']."' ORDER BY `id`");
while ($row = $PollOptions->FetchNextObject())
{
	$latest_poll .= "<input type='radio' name='id' value='$row->ID'>" . stripslashes($row->TEXT) . "<br />";
}

$latest_poll .= "<a href=\"viewpoll.php?id=".$PollResult->fields['id']."\">View Results</a><br />";

?>