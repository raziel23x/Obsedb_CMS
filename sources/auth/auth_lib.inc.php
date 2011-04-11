<?php
/************************************************************************/
/* PWZ_AUTH v2.2      	                                                */
/* ===================================                                  */
/*                                                                      */
/* http://opensource.spidmail.net                                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the BSD License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

function pwz_db($sql,$cfgmysql) {
	$pwz_cnx = @mysql_connect($cfgmysql['host'],$cfgmysql['user'],$cfgmysql['pass']) or trigger_error("unable to connect to DB server"); 
 	if (!empty($cfgmysql['db']))
		@mysql_select_db($cfgmysql['db']) or trigger_error("Unable to select DB");
	else
		@mysql_select_db($cfgmysql['user']) or trigger_error(("Unable to select user DB"));
	$r = @mysql_query($sql,$pwz_cnx) or trigger_error("DB error no ".mysql_errno().": ".mysql_error()); 
	@mysql_close ($pwz_cnx) or trigger_error("Unable to close DB");
	return $r;
}
function pwz_debug($pwzdebugmsg) {
	global $pwzdebug,$pwzpseudo,$pwzrefer;
	if ($pwzdebug==1) {
		$heure=date ("H:i");
		$jour=date ("j.m.Y");
		$pwzdebugmsg = $_SESSION['pwzlogin']." ".$pwzpseudo." ".$heure."-".$jour." : ".$pwzdebugmsg."\n";
		$fp=@fopen($pwzrefer,"a") or trigger_error("Unable to open log file");
		if (!$fp)
			return;
		@fputs($fp,$pwzdebugmsg) or trigger_error("Unable to write log file");
		@fclose($fp) or trigger_error("Unable to close log file");
	}
	return;
}
function pwz_errlevel($level) {
	$var="pwzunvalid_".$level;
	global $$var;
	$_SESSION['pwzmsg']=$$var;
	$_SESSION['pwzerr']=$level;
	return;
}
?>