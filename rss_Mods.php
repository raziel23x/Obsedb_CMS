<?php

require_once("global.php");

print "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
print "<rss version=\"2.0\">\n";
print "<channel>\n";
print "<title>$spconfig[site_title] - Mod Feed</title>\n";
print "<link>$Obsedb_url</link>\n";
print "<language>en-us</language>\n";
print "<copyright>Copyright (c) 2007</copyright>\n";

$result = $db->Execute("SELECT g.id,g.title,p.title AS platform FROM Obsedb_Mods AS g, Obsedb_Mods_sections AS p WHERE p.id = g.section ORDER BY g.id DESC LIMIT 0,10");
while($row = $result->FetchNextObject())
{
	print "<item>\n";
	print "<title>".stripslashes($row->TITLE)." (".stripslashes($row->PLATFORM).")</title>";
	print "<description></description>";
	print "<link>".$Obsedb_url."/Moddetails.php?id=$row->ID</link>";
	print "<pubDate>".date(d.m.Y)."</pubDate>\n";
	print "</item>";
}

print "</channel>\n";
print "</rss>\n";

?>