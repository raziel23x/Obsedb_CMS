<?php

// Generate Left Menu

function GenerateLeftMenu()
{
	global $db;

	$result = $db->Execute("
		SELECT * FROM Obsedb_menu_items
		WHERE `location` = 'left'
		AND `active` = '1'
		ORDER BY `ordering` ASC");

	while ( $row = $result->FetchNextObject())
	{
		if ( $row->TARGET == "_blank")
		{
			$left .= "<a href=\"$row->URL\" target=\"_blank\">" . stripslashes($row->TITLE) . "</a><br />";
		} else {
			$left .= "<a href=\"$row->URL\">" . stripslashes($row->TITLE) . "</a><br />";
		}
	}

	return $left;

}

function GenerateRightMenu()
{
	global $db;

	$result = $db->Execute("
		SELECT * FROM Obsedb_menu_items
		WHERE `location` = 'right'
		AND `active` = '1'
		ORDER BY `ordering` ASC");

	while ( $row = $result->FetchNextObject())
	{
		if ( $row->TARGET == "_blank")
		{
			$right .= "<a href=\"$row->URL\" target=\"_blank\">" . stripslashes($row->TITLE) . "</a><br />";
		} else {
			$right .= "<a href=\"$row->URL\">" . stripslashes($row->TITLE) . "</a><br />";
		}
	}

	return $right;

}

function GenerateLatestPoll()
{
	global $db;
	$PollResult = $db->Execute("SELECT * FROM `Obsedb_polls` ORDER BY `id` DESC LIMIT 1");
	$latest_poll = "<b>" . $PollResult->fields['title'] . "</b><br />";

	$PollOptions = $db->Execute("SELECT * FROM `Obsedb_polls_options` WHERE `poll_id` = '".$PollResult->fields['id']."' ORDER BY `id`");
	while ($row = $PollOptions->FetchNextObject())
	{
		$latest_poll .= "<input type='radio' name='id' value='$row->ID'>" . stripslashes($row->TEXT) . "<br />";
	}

	$latest_poll .= "<a href=\"viewpoll.php?id=".$PollResult->fields['id']."\">View Results</a><br />";
	return $latest_poll;
}

?>