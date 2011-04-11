<?php

$userinfo = array();

session_start ();



if ( isset($_POST['username']) && isset($_POST['password']))

{

   $_POST["username"] = mysql_real_escape_string($_POST["username"]);
   $_POST["password"] = mysql_real_escape_string($_POST["password"]);
   $check = $db->Execute("SELECT * FROM `Obsedb_users` WHERE username = '$_POST[username]'");
   $check2 = $db->Execute("SELECT * FROM `Obsedb_users` WHERE username = '$_POST[username]' AND password = '" . md5($_POST[password]) . "'");

   $verify = $check2->RecordCount();



   if ($verify == 0)

   {

      $userinfo['id'] = 0;

   } else {

      $_SESSION['username'] = $check->fields['username'];

      $_SESSION['password'] = sha1($check->fields['password']);

      $userinfo['id'] = $check->fields['id'];

      $userinfo['username'] = $check->fields['username'];

      $userinfo['email'] = $check->fields['email'];

   }

} else {

   if (!isset($_SESSION['username']))

   {

      $userinfo['id'] = 0;

   } else {

      $check = $db->Execute("SELECT * FROM `Obsedb_users` WHERE username = '".$_SESSION['username']."'");

      $verify = $check->RecordCount();

      if ($verify == 0)

      {

         $_SESSION = array();

         $userinfo['id'] = 0;

      }



      if (sha1($check->fields['password']) == $_SESSION['password'])

      {

         $userinfo['id'] = $check->fields['id'];

         $userinfo['username'] = $check->fields['username'];

         $userinfo['email'] = $check->fields['email'];

      }

   }

}



?>