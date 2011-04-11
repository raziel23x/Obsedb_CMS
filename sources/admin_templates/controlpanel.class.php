<?php

class AdminCP
{

    var $phrase;

	function header()
	{
		global $refresh, $adminlang;

		echo '	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
				<HTML>
				<HEAD>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
				<script language="JavaScript" type="text/javascript" src="../sources/admin_templates/richtext.js"></script>
				';

		if (isset($refresh))
		{
			echo '<meta http-equiv="refresh" content="3;url=',$refresh,'">';
		}

		echo '	<title>' . $this->phrase['control_panel_title_bar'] . $_SESSION['pwzlogin'] . '</title>';
        print "<style type=\"text/css\">\n";
        require_once("../templates/admin_css.css");
        print "</style>\n";
        print '
				</head>
				<body>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
					   <td class="header"><img src="../images/admin/logo.jpg"></td>
						<td class="header_right" width="100%">
						<font class="header_title">' . $this->phrase['control_panel_header'] . '</font><br />
						<a href="index2.php">' . $this->phrase['control_panel_home'] . '</a> |
						<a href="profile.php">' . $this->phrase['edit_profile'] . '</a> |
						<a href="logout.php">' . $this->phrase['log_out'] . '</a></td>
					</tr>
				</table>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
					  <td class="border">
					  <table border="0" cellspacing="0" cellpadding="0" width="100%">
						 <tr>
							<td valign="top">
							<table border="0" cellspacing="0" cellpadding="0" width="160">
							   <tr>
								  <td style="width: 100%; border: 1px solid #000000; background-color: #FFF;">
								  <table cellpadding="5" cellspacing="0" width="100%">
								  <tr><td style="color: #FFFFFF; font-size: 8pt; font-weight: bold; background: #000000;">' . $this->phrase['modules'] . '</td></tr>
								  </table>
								  <div class="menu">
								  <table cellpadding="0" cellspacing="0" class="menu">
								  ' . ListModules() . '
								  </table>
								  </div>
			';

		if (defined('SUPERADMIN_MODE'))
		{
			echo '

					<table cellpadding="5" cellspacing="0" width="100%">
					<tr><td style="color: #FFFFFF; font-size: 8pt; font-weight: bold; background: #000000;">' . $this->phrase['admin_tools'] . '</td></tr>
					</table>
					<div class="menu">
					<table cellpadding="0" cellspacing="0" class="menu">
					<tr>
						
						<td class="menu"><a href="configuration.php">'.$this->phrase['menu_settings'].'</a></td>
					</tr>
					<tr>
						
						<td class="menu"><a href="menu_manager.php">'.$this->phrase['menu_menumanager'].'</a></td>
					</tr>
					<tr>
						
						<td class="menu"><a href="modules.php">'.$this->phrase[menu_modules].'</a></td>
					</tr>
					<tr>
						
						<td class="menu"><a href="templates.php">'.$this->phrase[menu_templates].' (Beta)</a></td>
					</tr>
					<tr>
						
						<td class="menu"><a href="administrators.php">'.$this->phrase[menu_administrators].'</a></td>
					</tr>
					<tr>
					    <td class="menu"><a href="users.php">'.$this->phrase['menu_users'].'</a></td>
					</tr>
					<tr>
						
						<td class="menu"><a href="dbtools.php">'.$this->phrase[menu_utilities].'</a></td>
					</tr>
					<tr>
						
						<td class="menu"><a href="ver_check.php">'.$this->phrase[menu_updates].'</a></td>
					</tr>
					</table>
					</div>
				';
		}

		echo '	</td></tr></table>
				</td>
				<td width="100%" valign="top" class="main">
				';
	}

	function footer()
	{
		global $db, $pwzlogin, $Obsedb_version;
		
		$version = $db->Execute("SELECT VERSION() AS mysql_version;");
		
		print "</td>\n";
		print "<td valign=\"top\" style=\"background-color: #ffffff; border: 1px solid #d7d7d7; padding: 5px; line-height: 150%;\">\n";
		print "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"150\">\n";
		print "<tr><td>";
        print "<div style=\"border-bottom: 1px solid #d7d7d7;\">" . date("F j, Y, g:i a") . "</div>";
        print "Welcome, <b>$pwzlogin</b><br /><br />";
        print "<div style=\"border-bottom: 1px solid #d7d7d7;\"><b>Common Tasks</b></div>";
        print "<a href=\"companies.php?do=add_company\">Add Company</a><br />";
        print "<a href=\"Mods.php?do=add_Mod\">Add Mod</a><br />";
        print "<a href=\"news.php?do=add_news\">Add News</a><br />";
        print "<a href=\"previews.php?do=add_news\">Add Preview</a><br />";
        print "<a href=\"reviews.php?do=add_review\">Add Review</a><br />";
        print "<a href=\"screenshots.php?do=add_screenshot\">Add Screenshot</a><br />";
        print "<br />\n";
        print "<div style=\"border-bottom: 1px solid #d7d7d7;\"><b>Server</b></div>";
        print "PHP Version: " . phpversion() . "<br />";
        print "MySQL Version: " . $version->fields['mysql_version'] . "<br />";
        print "Obsedb CMS: " . $Obsedb_version . "<br />";
        print "<br />";
        if ( defined('SUPPORTID') )
        {
            print "<div style=\"border-bottom: 1px solid #d7d7d7;\"><b>Help Topics</b></div>";
            $result = $db->Execute("SELECT * FROM Obsedb_support WHERE `supportid` = '" . SUPPORTID . "' ORDER BY title");
            while ($row = $result->FetchNextObject())
            {
                print "<div style=\"padding: 2px; margin-top: 5px; margin-bottom: 5px; border: 1px solid #f5f5f5;\"><img src=\"../images/supportlink.jpg\" width=\"16\" height=\"16\" align=\"left\" style=\"padding-right: 5px;\"> <a href=\"$row->LINK\" target=\"_blank\">" . stripslashes($row->TITLE) . "</a></div>";
            }
        }
		print "</td></tr>\n";
		print "</table>\n";
		print "</td>\n";
		echo '</tr></table></td></tr></table><br />

			<table border="0" cellspacing="0" cellpadding="0" width="98%" align="center" style="border: 1px solid #1D6AA0;">
				<tr>
					<td class="formlabel" align="center">
					<a href="http://obsedb.co.cc/" target="_blank">
					Obsedb CMS - Copyright &copy; 2009
					</a>
					</td>
				</tr>
			</table><br />

			  </body>
			  </html>';
		$db->Close();
	}
	
	function getParam( $var )
	{
	    $var = $_REQUEST["$var"];
	    $var = mysql_real_escape_string($var);
	    return $var;
	}
	
    function getPhrases( $group )
    {
        global $db;
        $sql = "SELECT id,category,name,phrase FROM `Obsedb_phrases` WHERE `category` = '$group' ORDER BY `name`";
        $phrases = array();
        $result = $db->Execute( $sql ) or die( $db->ErrorMsg() );
        while ($row = $result->FetchNextObject())
        {
            $phrases[$row->NAME] = $row->PHRASE;
        }
        return $phrases;
    }

}

?>