<?php

class Form
{

    var $phrase;

    function initForm()
    {
        global $db, $cp, $spconfig;
        
        $this->phrase = $cp->getPhrases( 'adminConfiguration' );
        
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
            case 'edit_frontpage':
                $this->edit_frontpage();
                break;
            case 'adminAdministratorPhrases':
                $this->edit_phrases( 'adminAdministrators', 'Administrators Module Phrases' );
                break;
                
            case 'adminCheatsPhrases':
                $this->edit_phrases( 'adminCheats', 'Cheats Module Phrases' );
                break;
            case 'adminCompaniesPhrases':
                $this->edit_phrases( 'adminCompanies', 'Companies Module Phrases' );
                break;
            case 'adminConfigurationPhrases':
                $this->edit_phrases( 'adminConfiguration', 'Configuration Module Phrases' );
                break;
            case 'adminContentPhrases':
                $this->edit_phrases( 'adminContent', 'Content Module Phrases' );
                break;
            case 'adminIndexPhrases':
                $this->edit_phrases( 'adminIndex', 'Control Panel Index Phrases' );
                break;
                
            case 'adminCustomFieldsPhrases':
                $this->edit_phrases( 'adminCustomFields', 'Custom Fields Module Phrases' );
                break;
                
            case 'adminDatabasePhrases':
                $this->edit_phrases( 'adminDatabase', 'Database Module Phrases' );
                break;
                
            case 'adminDownloadsPhrases':
                $this->edit_phrases( 'adminDownloads', 'Downloads Module Phrases' );
                break;
                
            case 'adminModsPhrases':
                $this->edit_phrases( 'adminMods', 'Mods Module Phrases' );
                break;
                
            case 'adminMailbagPhrases':
                $this->edit_phrases( 'adminMailbag', 'Mailbag Module Phrases' );
                break;
                
            case 'adminMenuPhrases':
                $this->edit_phrases( 'adminMenu', 'Menu Manager Phrases' );
                break;
            case 'adminModulePhrases':
                $this->edit_phrases( 'adminModules', 'Module Manager Phrases' );
                break;
            case 'adminNewsPhrases':
                $this->edit_phrases( 'adminNews', 'News Module Phrases' );
                break;
            case 'adminPagesPhrases':
                $this->edit_phrases( 'adminPages', 'Static Pages Module Phrases' );
                break;
            case 'adminPluginsPhrases':
                $this->edit_phrases( 'adminPlugins', 'Plugin Manager Phrases' );
                break;               
            case 'adminPollsPhrases':
                $this->edit_phrases( 'adminPolls', 'Polls Module Phrases' );
                break;
            case 'adminPreviewsPhrases':
                $this->edit_phrases( 'adminPreviews', 'Previews Module Phrases' );
                break;
            case 'adminProfilePhrases':
                $this->edit_phrases( 'adminProfile', 'Profile Editor Phrases' );
                break;
            case 'adminMatrixPhrases':
                $this->edit_phrases( 'adminMatrix', 'Related Content Manager Phrases' );
                break;
            case 'adminReviewsPhrases':
                $this->edit_phrases( 'adminReviews', 'Review Module Phrases' );
                break;
            case 'adminScreenshotsPhrases':
                $this->edit_phrases( 'adminScreenshots', 'Screenshots Module Phrases' );
                break;
            case 'adminSectionsPhrases':
                $this->edit_phrases( 'adminSections', 'Sections Module Phrases' );
                break;
            case 'adminTemplatesPhrases':
                $this->edit_phrases( 'adminTemplates', 'Template Editor Phrases' );
                break;
            case 'adminUsersPhrases':
                $this->edit_phrases( 'adminUsers', 'User Manager Phrases' );
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
        do_blank_row( $spacer . $url . "adminAdministratorPhrases\">Administrator Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminCheatsPhrases\">Cheats Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminCompaniesPhrases\">Companies Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminConfigurationPhrases\">Configuration Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminContentPhrases\">Content Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminIndexPhrases\">Control Panel Index Phrases</a>" );
        do_blank_row( $spacer . $url . "adminCustomFieldsPhrases\">Custom Fields Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminDatabasePhrases\">Database Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminDownloadsPhrases\">Downloads Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminModsPhrases\">Mods Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminMailbagPhrases\">Mailbag Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminMenuPhrases\">Menu Manager Phrases</a>" );
        do_blank_row( $spacer . $url . "adminModulePhrases\">Module Manager Phrases</a>" );
        do_blank_row( $spacer . $url . "adminNewsPhrases\">News Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminPagesPhrases\">Pages Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminPluginsPhrases\">Plugins Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminPollsPhrases\">Polls Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminPreviewsPhrases\">Previews Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminProfilePhrases\">Profile Editor Phrases</a>" );
        do_blank_row( $spacer . $url . "adminMatrixPhrases\">Related Content Manager Phrases</a>" );
        do_blank_row( $spacer . $url . "adminReviewsPhrases\">Reviews Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminScreenshotsPhrases\">Screenshots Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminSectionsPhrases\">Sections Module Phrases</a>" );
        do_blank_row( $spacer . $url . "adminTemplatesPhrases\">Template Editor Phrases</a>" );
        do_blank_row( $spacer . $url . "adminUsersPhrases\">User Manager Phrases</a>" );
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
			'adminAdministratorPhrases' => 'Administrator Module Phrases',
			'adminCheatsPhrases' => 'Cheats Module Phrases',
			'adminCompaniesPhrases' => 'Companies Module Phrases',
			'adminConfigurationPhrases' => 'Configuration Module Phrases',
			'adminContentPhrases' => 'Content Module Phrases',
			'adminIndexPhrases' => 'Control Panel Index Phrases',
			'adminCustomFieldsPhrases' => 'Custom Fields Module Phrases',
			'adminDatabasePhrases' => 'Database Module Phrases',
			'adminDownloadsPhrases' => 'Downloads Module Phrases',
			'adminModsPhrases' => 'Mods Module Phrases',
			'adminMailbagPhrases' => 'Mailbag Module Phrases',
			'adminMenuPhrases' => 'Menu Manager Phrases',
			'adminModulePhrases' => 'Module Manager Phrases',
			'adminNewsPhrases' => 'News Module Phrases',
			'adminPagesPhrases' => 'Pages Module Phrases',
			'adminPluginsPhrases' => 'Plugins Module Phrases',
			'adminPollsPhrases' => 'Polls Module Phrases',
			'adminPreviewsPhrases' => 'Previews Module Phrases',
			'adminProfilePhrases' => 'Profile Editor Phrases',
			'adminMatrixPhrases' => 'Related Content Manager Phrases',
			'adminReviewsPhrases' => 'Reviews Module Phrases',
			'adminScreenshotsPhrases' => 'Screenshots Module Phrases',
			'adminSectionsPhrases' => 'Sections Module Phrases',
			'adminTemplatesPhrases' => 'Template Editor Phrases',
			'adminUsersPhrases' => 'User Manager Phrases'
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


	function editGlobal()
	{
		global $db, $spconfig;
		do_form_header( 'configuration.php' );
		do_table_header( 'Site Settings' );
		do_text_row( 'Website Title', 'site_title', clean($spconfig['site_title']) );
		do_text_row( 'Meta Description', 'meta_description', clean($spconfig['meta_description']) );
		do_text_row( 'Meta Keywords', 'meta_keywords', clean($spconfig['meta_keywords']) );
		do_text_row( 'Date Format', 'date_format', clean($spconfig['date_format']) );
		$options = array (
			2 => "User's Browser Does not Cache Pages.  Content Always Updated From Server",
			1 => "User's Browser Caches Pages.  Page Updaed From Server Each Reload",
			0 => "User's Browser Caches Pages.  Page Not Updaed From Server Each Reload"
		);
		do_select_row( 'True Refresh<br /></b><small><i>Forces user\'s browser to fetch new content on each reload</i></small>', 'true_refresh', $options, clean($spconfig['true_refresh']));
		do_submit_row( 'Save Configuration' );
		do_table_footer();
		echo '<input type="hidden" name="do" value="global_save">';
		do_form_footer();
	}



	function saveGlobal()
	{
		global $db;
		$this->saveConfig( 'site_title', $_REQUEST['site_title'] );
		$this->saveConfig( 'meta_description', $_REQUEST['meta_description'] );
		$this->saveConfig( 'meta_keywords', $_REQUEST['meta_keywords'] );
		$this->saveConfig( 'date_format', $_REQUEST['date_format'] );
		$this->saveConfig( 'true_refresh', $_REQUEST['true_refresh'] );
		SPMessage( 'Success | Changes have been saved.', 'configuration.php' );

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
	    do_select_row( 'Show tool icons in admin', 'Mod_tools', array('0'=>'Disabled','1'=>'Enabled'), $spconfig['Mod_tools']);
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
	
	function edit_frontpage()
	{
	    global $db,$cp,$spconfig;
	    do_form_header( 'configuration.php' );
	    do_table_header( 'Frontpage Settings' );
	    do_text_row( 'News Items', 'frontpage_news_limit', $spconfig['frontpage_news_limit'] );
	    do_text_row( 'Latest Mods Items', 'frontpage_latest_Mods_limit', $spconfig['frontpage_latest_Mods_limit'] );
	    do_text_row( 'Popular Mods Items', 'frontpage_popular_Mods_limit', $spconfig['frontpage_popular_Mods_limit'] );
	    do_text_row( 'Latest Previews Items', 'frontpage_previews_limit', $spconfig['frontpage_previews_limit'] );
	    do_text_row( 'Latest Reviews Items', 'frontpage_reviews_limit', $spconfig['frontpage_reviews_limit'] );
	    do_submit_row( 'Submit' );
	    do_table_footer();
	    do_hidden_row( 'do', 'save_frontpage' );
	    do_form_footer();
	}
	
	function save_frontpage()
	{
	    global $db,$cp;
	    $frontpage_news_limit = $cp->getParam( 'frontpage_news_limit' );
	    $frontpage_latest_Mods_limit = $cp->getParam( 'frontpage_latest_Mods_limit' );
	    $frontpage_popular_Mods_limit = $cp->getParam( 'frontpage_popular_Mods_limit' );
	    $frontpage_previews_limit = $cp->getParam( 'frontpage_previews_limit' );
	    $frontpage_reviews_limit = $cp->getParam( 'frontpage_reviews_limit' );
	    $this->saveConfig( 'frontpage_news_limit', $frontpage_news_limit );
	    $this->saveConfig( 'frontpage_latest_Mods_limit', $frontpage_latest_Mods_limit );
	    $this->saveConfig( 'frontpage_popular_Mods_limit', $frontpage_popular_Mods_limit );
	    $this->saveConfig( 'frontpage_previews_limit', $frontpage_previews_limit );
	    $this->saveConfig( 'frontpage_reviews_limit', $frontpage_reviews_limit );
	    SPMessage( "Configuration settings have been updated successfully.", "configuration.php?do=edit_frontpage" );
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