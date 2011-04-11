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

$location = " > <b>Mailbag</b>";

require_once("global.php");
switch ($_REQUEST['do']) {

   default:
      mailbag_main();
      break;

   }

function mailbag_main() {

    global $db;
    do_header();

    $tplHeader = new Template;
    $tplHeader->open_template( 'mailbag_header' );
    $tplHeader->print_template();
    
    $tplItem = new Template;
    $tplItem->open_template( 'mailbag_item' );

    $result = $db->Execute("SELECT * FROM `Obsedb_mailbag` ORDER BY `id` DESC");
    while ($row = $result->FetchNextObject())
    {

      $tplItem->addvar( '{title}', stripslashes($row->TITLE) );
      $tplItem->addvar( '{message}', clean($row->MESSAGE) );
      $tplItem->addvar( '{reply}', clean($row->REPLY) );
      $tplItem->parse_template();
      $tplItem->print_template();

    }

    $tplFooter = new Template;
    $tplFooter->open_template( 'mailbag_footer' );
    $tplFooter->print_template();


    do_footer();
}
?>