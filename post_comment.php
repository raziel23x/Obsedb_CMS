<?php

require_once('global.php');

if ( (isset($userinfo)) && ($userinfo['id'] != '0') )
{
	$username = $userinfo['username'];
	$comment = mysql_real_escape_string($_REQUEST['comment']);
	$content_id = mysql_real_escape_string($_REQUEST['contentid']);
} else {
	die("You must be logged in to post comments.");
}

switch($_REQUEST['m'])
{
	case 'Mods':
		post_comment_Mod( $username, $comment, $content_id );
		break;
}

function post_comment_Mod( $username, $comment, $content_id )
{
	global $db;
	$result = $db->Execute("INSERT INTO Obsedb_Mods_comments (Mod_id,username,date,comment) VALUES ('$content_id','$username',NOW(),'$comment')");
	header("Location: Moddetails.php?id=" . $content_id);
}

?>