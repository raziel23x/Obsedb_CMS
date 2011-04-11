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

error_reporting(E_ALL ^ E_NOTICE);
require_once("../config.php");

if ($_REQUEST['pwzpath']||$_REQUEST['pwztpldir']||$_REQUEST['pwzcookie_tpl']||$_REQUEST['pwzlogin_tpl']||$_REQUEST['pwzin']||$_REQUEST['pwzcookout']) {
	echo "Access Denied.";
	exit();
}

$pwzpath="../sources/auth/";

session_start();

include($pwzpath."auth_settings.inc.php");
include($pwzpath."auth_template.inc.php");

if (isset($_GET[pagevoulue])) {
  $pwzin = base64_decode($_GET[pagevoulue]);
}

if ( isset($_COOKIE[$pwzcookie]) ) {
  $data=unserialize(stripslashes($_COOKIE[$pwzcookie]));
  $pwzpseudo=$data[0];
  // Bienvenue - Connexion Garde via Cookie
  $html=pwz_tpl($pwztpldir,$pwzcookie_tpl);
} else {
  switch ($_SESSION['pwzerr']) {
  	case 1:
	  	$pwzerrorgeneral=$_SESSION['pwzmsg']; //variables Error
		$pwzerrorlogin="";  //Error user undefined
  		$pwzerrorpassword=""; //Password error
  		break;
  	case 2:
	  	$pwzerrorgeneral="";
		$pwzerrorlogin=$_SESSION['pwzmsg'];
  		$pwzerrorpassword="";
  		break;
  	case 3:
	  	$pwzerrorgeneral="";
		$pwzerrorlogin="";
  		$pwzerrorpassword=$_SESSION['pwzmsg'];
  		break;
  	default:
  		$pwzerrorgeneral="";
		$pwzerrorlogin="";
  		$pwzerrorpassword="";
  }
  $html=pwz_tpl($pwztpldir,$pwzlogin_tpl);
}
echo $html;
?>