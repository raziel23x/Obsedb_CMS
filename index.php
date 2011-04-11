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

require_once('global.php');
require_once('language/default/frontend_main.php');

switch ($_REQUEST['do']) {
   case 'viewarticle':
   	  $location = $LANG['loc_news'];
      view_article();
      break;
   case 'printarticle':
      print_article();
      break;
   default:
      index_main();
      break;
   }

function index_main()
   {
      global $db;
      do_header();
      require_once("templates/indexFrontpage.html.php");
      do_footer();
   }

function view_article()
   {
      do_header();
      include("templates/index_viewarticle.inc.php");
      build_matrix('news',$_REQUEST['id']);
      do_footer();
   }

function print_article()
   {
      include("templates/index_viewarticle.inc.php");
   }

?>