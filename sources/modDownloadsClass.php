<?php

class Module
{
    function main()
    {
        global $db;
        // Get Mod Info
        if (isset($_REQUEST['id'])) {
           $result = $db->Execute("SELECT * FROM `Obsedb_Mods` WHERE `id` = '$_REQUEST[id]' LIMIT 1");
           while ($row = $result->FetchNextObject()) {
	        $cheats = $db->Execute("SELECT id,Modid FROM `Obsedb_cheats` WHERE Modid = $_REQUEST[id] LIMIT 1");
	        if ($cheats->RecordCount() >= 1)
	        {
		        $cheat_link = "<a href=\"cheats.php?id=$row->ID\">Cheats</a>";
	        } else {
		        $cheat_link = "Cheats";
	        }
              do_header();
              
              $tplHeader = new Template;
              $tplHeader->open_template( 'downloads_header' );
              $tplHeader->addvar( '{title}', stripslashes($row->TITLE) );
              $tplHeader->addvar( '{id}', $row->ID );
              $tplHeader->addvar( '{cheat_link}', $cheat_link );
              $tplHeader->parse_template();
              $tplHeader->print_template();

              $downloads = $db->Execute("SELECT id,Modid,title,download FROM `Obsedb_downloads` WHERE `Modid` = '{$_REQUEST['id']}' ORDER BY `title`");
              while ($download = $downloads->FetchNextObject())
              {

      	        // DOWNLOAD HTML
      	        echo "<a href='".stripslashes($download->DOWNLOAD)."'>" . clean($download->TITLE) . "</a><br /><br />";

      	        // END DOWNLOAD HTML

              }
              
              $tplFooter = new Template;
              $tplFooter->open_template( 'downloads_footer' );
              $tplFooter->parse_template();
              $tplFooter->print_template();

              do_footer();

           }
        } else {
           do_header();
           echo "<b>System Error Message</b><br />";
           echo "You cannot access this page directly, please go back and select a Mod.<br />";
           echo "If the problem persists, please contact the webmaster.";
           do_footer();
        }
    }
}
?>