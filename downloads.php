<?
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

$location .= " > <a href=\"Mods.php\">Mods</a> > <b>Downloads</b>";

require_once("global.php");
require_once("sources/modDownloadsClass.php");

$module = new Module;
$module->main();

?>