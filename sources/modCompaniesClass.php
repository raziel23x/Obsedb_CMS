<?php

class Module
{
	function main()
	{
		global $db;

		$result = $db->Execute("SELECT id, title FROM Obsedb_companies ORDER BY title;");

		while ($row = $result->FetchNextObject())
		{
			$companies_list .= '<a href="companies.php?do=view&id='.$row->ID.'">'.clean($row->TITLE).'</a><br />';
		}

        do_header();
		$template = new Template;
		$template->open_template( 'company_list' );
		$template->addvar( '{company_list}', $companies_list );
		$template->parse_template();
		$template->print_template();
		do_footer();
	}

	function view()
	{
		global $db;

		if ( !is_numeric($_REQUEST['id']) )
		{
			die("Critical Error: Aborting script operations.");
		}

		$result = $db->Execute("SELECT * FROM Obsedb_companies WHERE id = $_REQUEST[id] LIMIT 1");

		$company = array();

		$company['title'] = stripslashes($result->fields['title']);
		$company['description'] = clean($result->fields['description']);

		if ( !empty($result->fields['homepage']) )
		{
			$company['homepage'] = '<a href="' . stripslashes($result->fields['homepage']) . '" target="_blank">'
										. stripslashes($result->fields['homepage']) . '</a>';
		}

		if ( !empty($result->fields['logo']) )
		{
			$company['logo'] .= "<img src=\"";
			$company['logo'] .= stripslashes($result->fields['logo']);
			$company['logo'] .= "\" alt=\"" . $company['title'] . " align=\"right\" hspace=\"2\" vspace=\"2\">";
		}

		$result = $db->Execute("
			SELECT id, title, section, developer
			FROM Obsedb_Mods
			WHERE developer = " . $_REQUEST['id'] . "
			ORDER BY title;");

		while ( $row = $result->FetchNextObject() )
		{
			$company['dev_links'] .= '<a href="Moddetails.php?id='.$row->ID.'">'.stripslashes($row->TITLE).'</a><br />';
		}

		$result = $db->Execute("
			SELECT id, title, section, publisher
			FROM Obsedb_Mods
			WHERE publisher = " . $_REQUEST['id'] . "
			ORDER BY title;");

		while ( $row = $result->FetchNextObject() )
		{
			$company['pub_links'] .= '<a href="Moddetails.php?id='.$row->ID.'">'.stripslashes($row->TITLE).'</a><br />';
		}


        do_header();   
        $template = new Template;
        $template->open_template( 'company_profile' );
        $template->addvar( '{title}', $company['title'] );
        $template->addvar( '{homepage}', $company['homepage'] );
        $template->addvar( '{logo}', $company['logo'] );
        $template->addvar( '{description}', $company['description'] );
        $template->parse_template();
        $template->print_template();
        if (!empty($company['dev_links'])) {
          $company_profile_devlinks = new Template;
          $company_profile_devlinks->open_template( 'company_profile_devlinks' );
          $company_profile_devlinks->addvar( '{links}', $company['dev_links'] );
          $company_profile_devlinks->parse_template();
          $company_profile_devlinks->print_template();
          }
        if (!empty($company['pub_links'])) {
          $company_profile_publinks = new Template;
          $company_profile_publinks->open_template( 'company_profile_publinks' );
          $company_profile_publinks->addvar( '{links}', $company['pub_links'] );
          $company_profile_publinks->parse_template();
          $company_profile_publinks->print_template();
          }
        do_footer();
	}
}

?>