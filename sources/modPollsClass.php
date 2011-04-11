<?php

class Module
{
	function main()
	{
		global $db;
		do_header();

		if (!empty($_REQUEST['id']))
		{
			$poll = $db->Execute("
				SELECT id,title
				FROM `Obsedb_polls`
				WHERE `id` = '" . $_REQUEST['id'] . "'");

			$result = $db->Execute("SELECT * FROM Obsedb_polls_options WHERE poll_id = '$_REQUEST[id]' ORDER BY id");
			while ( $row = $result->FetchNextObject() )
			{
				$poll_options .= "<tr><td bgcolor='#FFFFFF'>".stripslashes($row->TEXT)." - $row->COUNT votes</td></tr>";
			}

			if ($poll->RecordCount() < 1)
			{

				include "templates/poll_error.inc.php";

			} else {

				include "templates/poll_view.inc.php";

			}
		}
		do_footer();
	}
}
?>