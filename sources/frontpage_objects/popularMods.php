<?php

global $spconfig;
$limit = $spconfig['frontpage_popular_Mods_limit'];

$counter = 0;

$ModQuery = $db->Execute("
  SELECT g.id,g.title,p.title AS platform 
  FROM Obsedb_Mods AS g, Obsedb_Mods_sections AS p 
  WHERE g.section = p.id AND
  g.published = '1'
  ORDER BY g.views DESC
  LIMIT 0,$limit;");
while ($row = $ModQuery->FetchNextObject()) 
{
  $counter++;
  $Mods .= "<div style=\"padding: 3px;\">\n"
           ." <a href=\"Moddetails.php?id=$row->ID\"><b>" . stripslashes($row->TITLE) . "</b></a> "
           ."($row->PLATFORM)";
}

$frontpagePopularMods = new Template;
$frontpagePopularMods->open_template( 'frontpage_popular_Mods' );
$frontpagePopularMods->addvar( '{Mods}', $Mods );
$frontpagePopularMods->parse_template();
$frontpagePopularMods->print_template();

// Clear Mods variable
unset($Mods);

?>