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

// Configuration

// In case there's an invalid entry, use this URL
$pwzredir = $Obsedb_url . "/admin/login.php";

// First URL to protect (the one the script will log to)
$pwzin = "index.php";

// Kill cookie page
$pwzcookout = "logout.php";

// HTML templates Dir
$pwztpldir = "../sources/auth/template/";

// Template page : cookie connexion
$pwzcookie_tpl = "auth_cookie.html";

// Template page : connexion form
$pwzlogin_tpl = "auth_form.html";

// Template page : member subscription
$pwzinscription_tpl = "member.html";

// Messages to show
$pwzunvalid_1="Please log in to continue";
$pwzunvalid_2="Invalid Username/Password";
$pwzunvalid_3="Access Denied - Not enough resources";
$pwzvalid="Conection Refused";
$pwzregister="Inscription valide";
$pwznonregister="Login deja utilise";

// Cookie name
$pwzcookie="pwz_ln";

// Enable case-sensitive logins (0=off 1=on)
$pwzcase="0";

// Parametrage MySQL
// MySQL Settings

$pwzsql['host']=$db_host;
$pwzsql['user']=$db_user;
$pwzsql['pass']=$db_pass;
$pwzsql['db']=$db_name;
$pwzsql['table']="Obsedb_members";

// Schema table MySQL
// MySQL table scheme
$pwzscheme['ID']="ID";
$pwzscheme['USERNAME']="USERNAME";
$pwzscheme['PASSWORD']="PASSWORD";
$pwzscheme['E-Mail']="EMAIL";
$pwzscheme['Name']="NOM";
$pwzscheme['level']="PRIV";
$pwzscheme['state']="ACTIF";
$pwzscheme['expiration']="EXPIRE";
$pwzscheme['log']="LASTLOG";

// How long (in day) a registration is valid (empty=non expiration)
$pwzexpiration="";

// Connections and errors log
$pwzdebug=0;

// Path to log file, must be chmod +r
$pwzrefer="log.dat";

// Database update for last connection (0=no updates)
$pwztomaj=1;

// END OF SETTINGS
?>