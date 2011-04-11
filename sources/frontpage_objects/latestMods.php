<?php

// Template Information
// ======================================================================
// This template displays a table of the newest Mods that
// have been added to the site.
//
// You can alter the number of Mods displayed by changing
// the limit in the SQL statement. The default limit is 10.
// ======================================================================

global $spconfig;
$limit = $spconfig['frontpage_latest_Mods_limit'];

$result = $db->Execute("
  SELECT g.id,g.title,p.title AS platform 
  FROM Obsedb_Mods AS g, Obsedb_Mods_sections AS p 
  WHERE g.section = p.id AND
  g.published = '1'
  ORDER BY `id` DESC
  LIMIT 0,$limit;");
  
while ($row = $result->FetchNextObject())
{
  $Mods .= "<div style=\"padding: 3px;\">"
           ."<b><a href=\"Moddetails.php?id=$row->ID\">" . stripslashes($row->TITLE) . "</a></b> "
           ."(" . stripslashes($row->PLATFORM) . ")"
           ."</div>\n";
}

$frontpageLatestMods = new Template;
$frontpageLatestMods->open_template( 'frontpage_latest_Mods' );
$frontpageLatestMods->addvar( '{Mods}', $Mods );
$frontpageLatestMods->parse_template();
$frontpageLatestMods->print_template();

unset($Mods);

?>