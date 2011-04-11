<?php

// Get required files
require("global.php");

// Print control panel header
$cp->header();

// Links for module header
$links = '<a href="modules.php?do=install">Install Module</a>';

// Print module header
do_module_header('Module Manager',$links);

// Variables used by module
$do = $cp->getParam('do');
$id = $cp->getParam('id');

if (!isset($_REQUEST['do']))
{
	$result = $db->Execute("SELECT *
							FROM Obsedb_modules
							ORDER BY `title`;");

	while ($row = $result->FetchNextObject())
	{
	    if ($row->ACTIVE == '1')
	    {
	        $status = "Enabled";
	    } else {
	        $status = "Disabled";
	    }
	    do_table_header( "<b>" . stripslashes($row->TITLE) . "</b>" );
	    do_blank_row( "&nbsp;&nbsp;&nbsp;&nbsp; Status: $status" );
		if ($row->ACTIVE == '1')
		{
		    do_blank_row( "&nbsp;&nbsp;&nbsp;&nbsp; <a href='modules.php?do=unpublish&id=$row->ID'>Disable this module</a>" );
		} else {
			do_blank_row( "&nbsp;&nbsp;&nbsp;&nbsp; <a href='modules.php?do=publish&id=$row->ID'>Enable this module</a>" );
		}
		do_blank_row( "&nbsp;&nbsp;&nbsp;&nbsp; <a href='modules.php?do=edit&id=$row->ID'>Edit module configuration</a>" );
		do_table_footer();
	}


}

if ($_REQUEST['do'] == 'unpublish')
{
	if (empty($_REQUEST['id']))
	{
		echo 'Error: invalid module id number';
	} else {
		$record["active"] = '0';
		$db->AutoExecute("Obsedb_modules",$record,'UPDATE',"`id` = '{$_REQUEST['id']}'");
		SPMessage('Success | Module has been disabled','modules.php');
	}
}

if ($_REQUEST['do'] == 'publish')
{
	if (empty($_REQUEST['id']))
	{
		echo 'Error: invalid module id number';
	} else {
		$record["active"] = '1';
		$db->AutoExecute("Obsedb_modules",$record,'UPDATE',"`id` = '{$_REQUEST['id']}'");
		SPMessage('Success | Module has been enabled','modules.php');
	}
}

if ($_REQUEST['do'] == 'install')
{
	do_form_header('modules.php');
	do_table_header('Install Module');
	do_text_row('Title','title');
	do_text_row('Filename','filename');
	do_submit_row('Install');
	do_table_footer();
	echo '<input type="hidden" name="do" value="install2">';
	do_form_footer();
}

if ($_REQUEST['do'] == 'install2')
{
	$record["title"] = $_REQUEST['title'];
	$record["url"] = $_REQUEST['filename'];
	$db->AutoExecute("Obsedb_modules",$record,'INSERT');
	SPMessage('Success | Module has been added to control panel','modules.php');
}

if ($do == 'edit')
{
    $result = $db->Execute("
        SELECT * FROM Obsedb_modules
        WHERE `id` = '$id'");
    do_form_header('modules.php');
    do_table_header( 'Module Configuration' );
    do_text_row( 'Name', 'title', stripslashes($result->fields['title']) );
    do_text_row( 'Target', 'url', stripslashes($result->fields['url']) );
    do_submit_row( 'Save Changes' );
    do_table_footer();
    print '<input type="hidden" name="do" value="edit_confirm">';
    print '<input type="hidden" name="id" value="'.$id.'">';
    do_form_footer();
}

if ($do == 'edit_confirm')
{
    $title = $cp->getParam( 'title' );
    $url = $cp->getParam( 'url' );
    $record = array(
        'title' => $title,
        'url' => $url );
    $db->AutoExecute( 'Obsedb_modules', $record, "UPDATE", "`id` = '$id'" );
    SPMessage( "Module configuration has been saved." );
}
    

$cp->footer();

?>