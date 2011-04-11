<?php

require_once("global.php");

print "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
print "<rss version=\"2.0\">\n";
print "<channel>\n";
print "<title>$spconfig[site_title] - News Feed</title>\n";
print "<link>$Obsedb_url</link>\n";
print "<language>en-us</language>\n";
print "<copyright>Copyright (c) 2007</copyright>\n";

$result = $db->Execute("SELECT n.id,n.title,n.date,n.intro,p.title AS platform FROM Obsedb_news AS n, Obsedb_news_sections AS p WHERE p.id = n.section ORDER BY DATE_FORMAT(n.date,'%y%c%d') DESC LIMIT 0,10");
while($row = $result->FetchNextObject())
{
	print "<item>\n";
	print "\t<title>".stripslashes($row->TITLE)." (".stripslashes($row->PLATFORM).")</title>\n";
	print "\t<description>$row->INTRO</description>\n";
	print "\t<link>".$Obsedb_url."/index.php?do=viewarticle&amp;id=$row->ID</link>\n";
	print "\t<pubDate>$row->DATE</pubDate>\n";
	print "</item>\n";
}

print "</channel>\n";
print "</rss>\n";

?>