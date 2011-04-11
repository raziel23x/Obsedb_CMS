<?php

include "global.php";

$cp->header();

do_module_header( 'Template Editor', '<a href="templates.php">List Templates</a>' );



switch( $_REQUEST["do"] )
{
    case 'edit':
        edit_template($_REQUEST["title"]);
        break;
    case 'save':
        save_template( $_REQUEST[title], $_REQUEST[html] );
        edit_template( $_REQUEST[title] );
        break;
    default:
        list_templates();
        break;
}



$cp->footer();

function list_templates()
{
    do_table_header("Manage Templates");
    do_blank_row("<b>Default Template</b>");
    do_blank_row("
    
                  <ul><b>Global Templates</b>
                    <li><a href=\"templates.php?do=edit&title=header\">header</a>
                    <li><a href=\"templates.php?do=edit&title=footer\">footer</a>
                    <li><a href='templates.php?do=edit&title=stylesheet'>stylesheet</a>
                  </ul>
                  <ul>
                    <b>Cheats Templates</b>
                    <li><a href='templates.php?do=edit&title=cheats_header'>cheats_header</a>
                  </ul>
                  <ul>
                    <b>Company List Templates</b>
                    <li><a href='templates.php?do=edit&title=company_list'>company_list</a>
                  </ul>
                  <ul>
                    <b>Company Profile Templates</b>
                    <li><a href='templates.php?do=edit&title=company_profile'>company_profile</a>
                    <li><a href='templates.php?do=edit&title=company_profile_devlinks'>company_profile_devlinks</a>
                    <li><a href='templates.php?do=edit&title=company_profile_publinks'>company_profile_publinks</a>
                  </ul>
                  <ul>
                    <b>Downloads Module Templates</b>
                    <li><a href='templates.php?do=edit&title=downloads_header'>downloads_header</a>
                    <li><a href='templates.php?do=edit&title=downloads_footer'>downloads_footer</a>
                  </ul>
                  <ul>
                    <b>Frontpage Templates</b>
                    <li><a href='templates.php?do=edit&title=frontpage_latest_Mods'>frontpage_latest_Mods</a>
                    <li><a href='templates.php?do=edit&title=frontpage_popular_Mods'>frontpage_popular_Mods</a>
                  </ul>
                  <ul>
                    <b>Mod List Templates</b>
                    <li><a href=\"templates.php?do=edit&title=Modlist_footer\">Modlist_footer</a>
                    <li><a href='templates.php?do=edit&title=Modlist_header'>Modlist_header</a>
                    <li><a href='templates.php?do=edit&title=Modlist_row'>Modlist_row</a>
                  </ul>
                  <ul>
                    <b>Mod Profile Templates</b>
                    <li><a href='templates.php?do=edit&title=Mod_profile'>Mod_profile</a>
                  </ul>
                  <ul><b>Menu Templates</b>
                    <li><a href=\"templates.php?do=edit&title=log_in_box\">log_in_box</a>
                    <li><a href=\"templates.php?do=edit&title=logged_in_box\">logged_in_box</a>
                  </ul>
                  ");
    do_table_footer();
}

function edit_template( $title )
{
    global $db;
    do_table_header("Manage Templates");
    $result = $db->Execute("SELECT * FROM Obsedb_templates WHERE `title` = '$title';");
    do_form_header( 'templates.php' );
    do_blank_row("Editing Template");
    print "<tr><td class=\"formlabel\">\n"
         ."<textarea rows=\"20\" cols=\"70\" name=\"html\">"
         .stripslashes($result->fields['html'])
         ."</textarea></td></tr>";
    do_submit_row("Save Template");
    
    print '<input type="hidden" name="title" value="'.$title.'">';
    print '<input type="hidden" name="do" value="save">';
    do_table_footer();
    do_form_footer();
    
}

function save_template( $title, $html )
{
    global $db;
    $html = addslashes($html);
    $result = $db->Execute("UPDATE `Obsedb_templates` SET `html` = '$html' WHERE `title` = '$title'");
    SPMessage("Changes have been saved.");
}
?>