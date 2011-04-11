<?php

require_once( 'global.php' );
$do = $_REQUEST[ 'do' ];
$cp->header();

switch( $do )
{
    default:
        list_sections();
        break;
}

$cp->footer();

function list_sections() 
{
    global $db;
    do_module_header( 'Sections', 'Manage all the sections of your website' );
    
    do_table_header( 'Mod Sections' );
    do_blank_row('<a href="Mods.php?do=add_section">Add Section</a>');
    $result = $db->Execute( "SELECT id,title FROM `Obsedb_Mods_sections` ORDER BY `title`" );
    while ($row = $result->FetchNextObject())
    {
        do_blank_row( "<b>" . stripslashes($row->TITLE) . "</b>" );
        do_blank_row( "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &middot; <a href='Mods.php?do=Edit+Section&id=$row->ID'>Change the section name</a>" );
        do_blank_row( "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &middot; <a href='Mods.php?do=Delete+Section&id=$row->ID'>Delete the section</a>" );
    }
    do_table_footer();
    
    do_table_header( 'News Sections' );
    do_blank_row('<a href="news.php?do=add_section">Add Section</a>');
    $result = $db->Execute( "SELECT id,title FROM `Obsedb_news_sections` ORDER BY `title`" );
    while ($row = $result->FetchNextObject())
    {
        do_blank_row( "<b>" . stripslashes($row->TITLE) . "</b>" );
        do_blank_row( "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &middot; <a href='news.php?do=Edit+Section&id=$row->ID'>Change the section name</a>" );
        do_blank_row( "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &middot; <a href='news.php?do=Delete+Section&id=$row->ID'>Delete the section</a>" );
    }
    
    do_table_footer();
    
    do_table_header( 'Previews Sections' );
    do_blank_row('<a href="previews.php?do=add_section">Add Section</a>');
    $result = $db->Execute( "SELECT id,title FROM `Obsedb_previews_sections` ORDER BY `title`" );
    
    while ($row = $result->FetchNextObject())
    {
        do_blank_row( "<b>" . stripslashes($row->TITLE) . "</b>" );
        do_blank_row( "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &middot; <a href='previews.php?do=Edit+Section&id=$row->ID'>Change the section name</a>" );
        do_blank_row( "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &middot; <a href='previews.php?do=Delete+Section&id=$row->ID'>Delete the section</a>" );
    }
    
    do_table_footer();
    
    do_table_header( 'Reviews Sections' );
    do_blank_row('<a href="reviews.php?do=add_section">Add Section</a>');
    $result = $db->Execute( "SELECT id,title FROM `Obsedb_reviews_sections` ORDER BY `title`" );
    
    while ($row = $result->FetchNextObject())
    {
        do_blank_row( "<b>" . stripslashes($row->TITLE) . "</b>" );
        do_blank_row( "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &middot; <a href='reviews.php?do=Edit+Section&id=$row->ID'>Change the section name</a>" );
        do_blank_row( "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &middot; <a href='reviews.php?do=Delete+Section&id=$row->ID'>Delete the section</a>" );
    }
    
    do_table_footer();
}

?>