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

if ( $_REQUEST['pwzpath'] || 
     $_REQUEST['pwzrequire'] || 
     $_REQUEST['login_not_required'] ) 
{
	echo "Error: Access Denied.";
	exit();
}

require_once("auth_settings.inc.php");
require_once("auth_lib.inc.php");

// INIT VARIABLES
unset($pwzpseudo);
unset($pwzpass);
$pagevoulue = base64_encode( $_SERVER['REQUEST_URI'] );
$pwziscoded = 0;
$pwzmaj = 0;
$pwzloc = "Location: " . $pwzredir."?pagevoulue=" . $pagevoulue;

// OPEN PHP SESSION
session_start();

// Niveau d'erreur 1
pwz_errlevel( 1 );

// On essaye de recuperer un cookie
if ( (!$_SESSION['pwzlogin'] && !$_SESSION['pwzpassword']) && ( isset($_COOKIE[$pwzcookie]) ) ) 
{
	$data=unserialize(stripslashes($_COOKIE[$pwzcookie]));
	$pwzpseudo=$data[0];
	$pwzpass=$data[1];
	$pwziscoded=1;
	pwz_debug("Reprise cookie");
// Sinon on recupere les variables postes
// Register globals Off compliant
} elseif ( isset($_POST['pwzpseudo']) && isset($_POST['pwzpass'])) {
	$pwzpseudo=$_POST['pwzpseudo'];
	$pwzpass=$_POST['pwzpass'];
	pwz_debug("Recuperation des variables POST");
} else {
	pwz_debug("Aucune information de connexion");
}

// Verification s'il s'agit d'une nouvelle connexion ou pas
if (!$pwzpseudo && !$pwzpass) {
	pwz_debug("Reprise Session");
} else {
	// on utilise les donnees saisies pour rentrer
	unset ($_SESSION['pwzlogin']);
	unset ($_SESSION['pwpassword']);
	unset ($_SESSION['pwzid']);
	unset ($_SESSION['pwzpriv']);
	unset ($_SESSION['pwz_logon']);

	// codage password
	$_SESSION["pwzlogin"] = addslashes(htmlentities($pwzpseudo));
	if ($pwziscoded==0)
		$_SESSION["pwzpassword"] = md5($pwzpass);
	else
		$_SESSION["pwzpassword"] = $pwzpass;
	pwz_debug("Pass crypte ".$_SESSION["pwzpassword"]);
	$pwzmaj=1;
}

if ( (!$_SESSION["pwzlogin"]) && (!$_SESSION["pwzpassword"]) && ($login_not_required==1) && !isset($_REQUEST['login_not_required']) ) {
	$_SESSION['pwz_logon']=false;
	pwz_debug("Login non necessaire - Acces autorise");
} else {

	if (!$_SESSION["pwzlogin"]) {
		// attention pas de login
		pwz_debug("Pas de login");
	    	Header ($pwzloc);
		exit;
	}
	if (!$_SESSION["pwzpassword"]) {
		// attention pas de mot de passe
		pwz_debug("Pas de Pass");
	    	Header ($pwzloc);
		exit;
	}

	// Requete DB
	$userQuery = pwz_db("
		SELECT
			Obsedb_members.ID AS ID, Obsedb_members.USERNAME AS USERNAME, Obsedb_members.PASSWORD AS PASSWORD,
			Obsedb_members.PRIV AS PRIV, Obsedb_members.EXPIRE AS EXPIRE
		FROM
			Obsedb_members
		WHERE
			USERNAME = '{$_SESSION["pwzlogin"]}' AND
			ACTIF = '1'", $pwzsql);

	pwz_debug("Requete Acces 1");

	// Niveau d'erreur 2
	pwz_errlevel(2);

	// on verifie Utilisateur d'abord
	if (mysql_num_rows($userQuery) != 0) {
		// l'utilisateur existe
		$userArray = mysql_fetch_array($userQuery);

		if ((strtolower($_SESSION["pwzlogin"]) != strtolower($userArray['USERNAME']) && $pwzcase==0)||($_SESSION["pwzlogin"] != $userArray['USERNAME'] && $pwzcase==1)) {
			pwz_debug("Login different de la base");
			Header ($pwzloc);
			exit;
		}
	} else {
		// Pas de reponse dans la base
		pwz_debug("Login inconnu");
		Header ($pwzloc);
		exit;
	}

	if (!$userArray['PASSWORD']) {
		// Attention pas de mot de passe dans la base - Non autorise
		pwz_debug("Pas de pass dans la base");
		Header ($pwzloc);
		exit;
	}

	if ($userArray["PASSWORD"] != $_SESSION["pwzpassword"]) {
		// mot de passe FAUX
		pwz_debug("Pass incorrect ".$_SESSION["pwzpassword"]);
		Header ($pwzloc);
		exit;
	}

	// Niveau d'erreur 3
	pwz_errlevel(3);

	if (isset($pwzrequire) && ($userArray["PRIV"] < $pwzrequire)) {
	  // Niveau trop bas
	  pwz_debug("Niveau trop bas ");
	  Header ($pwzloc);
	  exit;
	}

	// Gestion Date Expiration
	if (!empty($pwzexpiration) && strtotime($userArray["EXPIRE"])<time()) {
	  // Membership expire
	  pwz_debug("Membership expire");
	  Header ($pwzloc);
	  exit;
	}

	$_SESSION['pwzid']=$userArray["ID"];
	$_SESSION['pwzpriv']=$userArray["PRIV"];
	$_SESSION['pwzmsg']=$pwzvalid;
	$_SESSION['pwzsid']=session_name()."=".session_id() ;
	$_SESSION['pwz_logon']=true;

	pwz_debug("Acces valide");

	// Pose du cookie
	if (!empty($_POST['pwzautologin'])) {
		$datacookie=serialize(array($_SESSION['pwzlogin'],$_SESSION["pwzpassword"]));
		SetCookie($pwzcookie,$datacookie,time()+31536000,"/","");
		pwz_debug("Cookie cree");
	}

	if (($pwzmaj == 1) && ($pwztomaj==1)) {
		$heure=date ("H:i");
		$jour=date ("j.m.Y");
		$query = pwz_db("update ".$pwzsql['table']." SET {$pwzscheme['log']}=now() Where {$pwzscheme['pseudo']}=\"{$_SESSION["pwzlogin"]}\"",$pwzsql);
		if ($query != 1)
		{
			print " MAJ Log impossible";
			pwz_debug("MAJ Log impossible");
			exit;
		}
	}
}
?>