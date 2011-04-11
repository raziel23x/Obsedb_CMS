<?php

class Module
{
    function main()
    {
        global $db;
        if (isset($_REQUEST['id'])) {
           $result = $db->Execute("SELECT * FROM `Obsedb_Mods` WHERE `id` = '$_REQUEST[id]' LIMIT 1");
           while ($row = $result->FetchNextObject()) {

              do_header();
              
              $header = new Template;
              $header->open_template( 'cheats_header' );
              $header->addvar( '{id}', $row->ID );
              $header->addvar( '{title}', stripslashes($row->TITLE) );
              $header->parse_template();
              $header->print_template();

              $cheats = $db->Execute("SELECT id,Modid,title,cheat FROM `Obsedb_cheats` WHERE `Modid` = '{$_REQUEST['id']}' ORDER BY `title`");
              while ($cheat = $cheats->FetchNextObject())
              {

      	        // CHEAT HTML
      	        echo "<b>" . clean($cheat->TITLE) . "</b><br />
      			        " . stripslashes($cheat->CHEAT) . "<br /><br />";
      	        // END CHEAT HTML

              }

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