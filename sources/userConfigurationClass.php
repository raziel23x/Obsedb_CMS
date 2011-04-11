<?php

class Form
{

    var $phrase;

    function initForm()
    {
        global $db, $cp, $spconfig;
        
        $this->phrase = $cp->getPhrases( 'userConfiguration' );
        
        $setting = $cp->getParam( 'setting' );
        $do = $cp->getParam( 'do' );
        
        $cp->header();
        $this->printHeader();

        switch($setting)
        {
	        default:
	            $this->main();
		        break;
	        case 'global':
		        $this->editGlobal();
		        break;
            case 'screenshots':
                $this->edit_screenshots();
                break;
            case 'Mods':
                $this->edit_Mods();
                break;
            case 'userCheatsPhrases':
                $this->edit_phrases( 'userCheats', 'Cheats Module Phrases' );
                break;
            case 'userCompaniesPhrases':
                $this->edit_phrases( 'userCompanies', 'Companies Module Phrases' );
                break;
            case 'userConfigurationPhrases':
                $this->edit_phrases( 'userConfiguration', 'Configuration Module Phrases' );
                break;
            case 'userContentPhrases':
                $this->edit_phrases( 'userContent', 'Content Module Phrases' );
                break;
            case 'userIndexPhrases':
                $this->edit_phrases( 'userIndex', 'Control Panel Index Phrases' );
                break;
                
            case 'userDownloadsPhrases':
                $this->edit_phrases( 'userDownloads', 'Downloads Module Phrases' );
                break;
                
            case 'userModsPhrases':
                $this->edit_phrases( 'userMods', 'Mods Module Phrases' );
                break;             

            case 'userPreviewsPhrases':
                $this->edit_phrases( 'userPreviews', 'Previews Module Phrases' );
                break;
            case 'userProfilePhrases':
                $this->edit_phrases( 'userProfile', 'Profile Editor Phrases' );
                break;
            case 'userMatrixPhrases':
                $this->edit_phrases( 'userMatrix', 'Related Content Manager Phrases' );
                break;
            case 'userReviewsPhrases':
                $this->edit_phrases( 'userReviews', 'Review Module Phrases' );
                break;
            case 'userScreenshotsPhrases':
                $this->edit_phrases( 'userScreenshots', 'Screenshots Module Phrases' );
                break;
            case 'controlpanel':
                $this->edit_controlpanel();
                break;
            

        }

        switch($do)
        {
	        default:
		        break;
	        case 'global_save':
		        $this->saveGlobal();
		        break;
            case 'screenshots_save':
                $this->save_screenshots();
                break;
            case 'Mods_save':
                $this->save_Mods();
                break;
            case 'save_frontpage':
                $this->save_frontpage();
                break;
            case 'save_phrases':
                $this->save_phrases();
                break;
        }

        $cp->footer();
    }
    
    function main()
    {
        do_table_header('Settings & Phrases');
        do_blank_row("<b>Settings</b>");
        $spacer = "&nbsp; &nbsp; &middot; ";
        $url = "<a href=\"configuration.php?setting=";
        do_blank_row( $spacer . $url . "global\">Obsedb CMS Settings</a>" );
        do_blank_row( $spacer . $url . "controlpanel\">Control Panel Settings</a>" );
        do_blank_row( $spacer . $url . "edit_frontpage\">Frontpage Settings</a>" );
        do_blank_row( $spacer . $url . "Mods\">Mods Module</a>" );
        do_blank_row( $spacer . $url . "screenshots\">Screenshots Module</a>" );
        do_blank_row("<b>Phrase Groups</b>");
        do_blank_row( $spacer . $url . "userCheatsPhrases\">Cheats Module Phrases</a>" );
        do_blank_row( $spacer . $url . "userCompaniesPhrases\">Companies Module Phrases</a>" );
        do_blank_row( $spacer . $url . "userContentPhrases\">Content Module Phrases</a>" );
        do_blank_row( $spacer . $url . "userIndexPhrases\">Control Panel Index Phrases</a>" );
        do_blank_row( $spacer . $url . "userDownloadsPhrases\">Downloads Module Phrases</a>" );
        do_blank_row( $spacer . $url . "userModsPhrases\">Mods Module Phrases</a>" );
        do_blank_row( $spacer . $url . "userMailbagPhrases\">Mailbag Module Phrases</a>" );
        do_blank_row( $spacer . $url . "userMenuPhrases\">Menu Manager Phrases</a>" );
        do_blank_row( $spacer . $url . "userModulePhrases\">Module Manager Phrases</a>" );
        do_blank_row( $spacer . $url . "userNewsPhrases\">News Module Phrases</a>" );
        do_blank_row( $spacer . $url . "userPagesPhrases\">Pages Module Phrases</a>" );
        do_blank_row( $spacer . $url . "userPreviewsPhrases\">Previews Module Phrases</a>" );
        do_blank_row( $spacer . $url . "userProfilePhrases\">Profile Editor Phrases</a>" );
        do_blank_row( $spacer . $url . "userMatrixPhrases\">Related Content Manager Phrases</a>" );
        do_blank_row( $spacer . $url . "userReviewsPhrases\">Reviews Module Phrases</a>" );
        do_blank_row( $spacer . $url . "userScreenshotsPhrases\">Screenshots Module Phrases</a>" );
        do_table_footer();
    }


	function saveConfig( $key, $value='' )
	{
		global $db;
		$db->Execute( "UPDATE Obsedb_configuration SET `value` = '$value' WHERE `key` = '$key'" );
	}
	
	function savePhrase( $category, $name, $phrase )
	{
	    global $db;
	    $db->Execute( "UPDATE `Obsedb_phrases` SET `phrase` = '$phrase' WHERE `name` = '$name' AND `category` = '$category'");
	}



	function printHeader()
	{
	    global $cp;
	    do_module_header( $this->phrase['module_header'], $this->phrase['module_header_links'] );
		do_form_header( 'configuration.php' );
		do_table_header( $this->phrase['setting'] );
		
		$options = array(
		    'global' => 'Site Settings',
		    'controlpanel' => 'Control Panel Settings',
			'Mods' => 'Mods Module',
			'screenshots' => 'Screenshots Module',
			'userCheatsPhrases' => 'Cheats Module Phrases',
			'userCompaniesPhrases' => 'Companies Module Phrases',
			'userConfigurationPhrases' => 'Configuration Module Phrases',
			'userContentPhrases' => 'Content Module Phrases',
			'userIndexPhrases' => 'Control Panel Index Phrases',
			'userCustomFieldsPhrases' => 'Custom Fields Module Phrases',
			'userDatabasePhrases' => 'Database Module Phrases',
			'userDownloadsPhrases' => 'Downloads Module Phrases',
			'userModsPhrases' => 'Mods Module Phrases',
			'userMenuPhrases' => 'Menu Manager Phrases',
			'userModulePhrases' => 'Module Manager Phrases',
			'userNewsPhrases' => 'News Module Phrases',
			'userPagesPhrases' => 'Pages Module Phrases',
			'userPluginsPhrases' => 'Plugins Module Phrases',
			'userPreviewsPhrases' => 'Previews Module Phrases',
			'userProfilePhrases' => 'Profile Editor Phrases',
			'userMatrixPhrases' => 'Related Content Manager Phrases',
			'userReviewsPhrases' => 'Reviews Module Phrases',
			'userScreenshotsPhrases' => 'Screenshots Module Phrases',
			);
			
	    $setting = $cp->getParam( 'setting' );
	    do_select_row('Settings and Phrases Quick Jump','setting',$options,$setting);
		
		do_submit_row( 'Edit Settings' );
		do_table_footer();
		do_form_footer();
	}
	
	
	function edit_controlpanel()
	{
	    global $db, $spconfig;
	    do_form_header('configuration.php');
	    do_table_header('Control Panel Settings');
	    do_text_row('Control Panel Home - Recent Mod Items','cphome_recent_Mods',$spconfig['cphome_recent_Mods']);
	    do_submit_row('Save Configuration');
	    do_table_footer();
	    do_hidden_row('do','save_controlpanel');
	    do_form_footer();
	}

	
	function edit_screenshots()
	{
	    global $db, $spconfig;
	    do_form_header( 'configuration.php' );
	    do_table_header( 'Screenshot Module Settings' );
	    do_select_row( 'Enable Upload Feature', 'screenshots_upload', array('0' => 'No', '1' => 'Yes'), $spconfig['screenshots_upload']);
	    do_select_row( 'Enable Auto-Thumbnailing Feature', 'screenshots_thumbnailing', array('0' => 'No', '1' => 'Yes'), $spconfig['screenshots_thumbnailing']);
	    do_submit_row( 'Submit' );
	    do_table_footer();
	    print '<input type="hidden" name="do" value="screenshots_save">';
	    do_form_footer();
	}
	
	function save_screenshots()
	{
	    global $db;
	    $this->saveConfig( 'screenshots_upload', $_REQUEST['screenshots_upload'] );
	    $this->saveConfig( 'screenshots_thumbnailing', $_REQUEST['screenshots_thumbnailing'] );
	    SPMessage( "Configuration settings have been updated successfully.", "configuration.php" );
	}
	
	function edit_Mods()
	{
	    global $db, $spconfig;
	    do_form_header( 'configuration.php' );
	    do_table_header( 'Mods Module Settings' );
	    do_select_row( 'Show tool icons in user', 'Mod_tools', array('0'=>'Disabled','1'=>'Enabled'), $spconfig['Mod_tools']);
	    do_select_row( 'Open tool icons in new windows', 'Mod_tools_popups', array('0'=>'Disabled','1'=>'Enabled'), $spconfig['Mod_tools_popups']);
	    do_submit_row( 'Submit' );
	    do_table_footer();
	    print '<input type="hidden" name="do" value="Mods_save">';
	    do_form_footer();
	}
	
	function save_Mods()
	{
	    global $db;
	    $this->saveConfig( 'Mod_tools', $_REQUEST["Mod_tools"] );
	    $this->saveConfig( 'Mod_tools_popups', $_REQUEST["Mod_tools_popups"] );
	    SPMessage( "Configuration settings have been updated successfully.", "configuration.php" );
	}
	
	
	function edit_phrases( $category, $label )
	{
	    global $db, $cp;
	    $phrases = $cp->getPhrases( $category );
	    
	    do_form_header( 'configuration.php' );
	    do_table_header( $label );
	    foreach ($phrases AS $key => $value)
	    {
	        do_text_row( $key, $key, $value );
	    }
	    do_submit_row( 'Save Phrases' );
	    do_table_footer();
	    print "<input type=\"hidden\" name=\"category\" value=\"" . $category . "\">";
	    print "<input type=\"hidden\" name=\"do\" value=\"save_phrases\">";
	    do_form_footer();
	}
	
	function save_phrases()
	{
	    global $db, $cp;
	    $category = $cp->getParam( 'category' );
	    $phrases = $cp->getPhrases( $category );
	    foreach ($phrases AS $key => $value)
	    {
	        $this->savePhrase( $category, $key, $_REQUEST[$key] );
	    }
	    SPMessage( "Phrases have been updated." );
	}
}

?>