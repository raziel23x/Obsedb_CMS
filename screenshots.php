<?php

require_once("global.php");
do_header();

switch($_REQUEST["do"])
{
    default:
        view_screenshot($_REQUEST['id']);
        break;
    case 'list':
        list_screenshots($_REQUEST['id']);
        break;
}

function view_screenshot( $id )
{
    global $db;
    
    $result = $db->Execute("
        SELECT * FROM Obsedb_screenshots
        WHERE `id` = '$id' LIMIT 0,1;");
    print "<b>" . stripslashes($result->fields["title"]) . "</b><br /><br />";
    print "<center>";
    print "<img src=\"" . $result->fields["screen"] . "\" border=\"0\" alt=\"" . stripslashes($result->fields["title"]) . "\">";
    print "</center>";
}

function list_screenshots( $id )
{
    global $db;
    
    $Mod = $db->Execute("
        SELECT g.id,g.title,p.title AS platform 
        FROM Obsedb_Mods AS g, Obsedb_Mods_sections AS p
        WHERE g.id = '$id' AND g.section = p.id");
    
    print "<h3>" . stripslashes($Mod->fields['title']) . " (" . stripslashes($Mod->fields['platform']) . ") " . " Screenshots</h3>";
    
    $result = $db->Execute("SELECT * FROM Obsedb_screenshots WHERE `section` = '$id'");
    $counter = 0;
    print "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">";
    while ($row = $result->FetchNextObject()) {
        $counter++;
        if ($counter == '1') { echo "<tr>"; }
        echo "<td align=\"center\" width=\"33%\"><a href=\"screenshots.php?id=".$row->ID."\"><img src=\"$row->THUMB\" border=\"0\"></a><br /><br /></td>";
        if ($counter == '3') {
            echo "</tr>";
            $counter = 0;
        }
    }
    print "</tr></table>";
}

do_footer();
?>