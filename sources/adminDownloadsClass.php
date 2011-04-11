<?php

class Module {

    var $phrase;

    function initForm()
    {
        global $db, $cp;
        
        $this->phrase = $cp->getPhrases( 'adminDownloads' );
        
        $cp->header();
        $this->header();
        switch($_REQUEST['do'])
        {
	        case 'add':
		        $this->add();
		        break;
	        case 'add_download_confirm':
		        $this->add_confirm();
		        break;
	        case 'delete':
		        $this->delete();
		        break;
	        case 'edit':
		        $this->edit();
		        break;
	        case 'edit_download_confirm':
		        $this->edit_confirm();
		        break;
	        case 'manage':
		        $this->manage();
		        break;
	        default:
		        $this->main();
		        break;
        }
        $cp->footer();

    }

	function header()
	{
		$links = "<a href=downloads.php>Manage Downloads</a> | "
		        ."<a href=\"downloads.php?do=add\">Add Download</a>";
		
		do_module_header('Downloads',$links);
	}

	function main()
	{
		global $db;
		do_table_header('Downloads');
		echo "<tr><td class=\"formlabel\"><b>";

		$alpha = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9','0');
		foreach($alpha AS $value)
		{
			echo "<a href=\"downloads.php?browse=$value\">$value</a> &nbsp;";
		}
		echo "</b></td></tr>";
		if (empty($_REQUEST['browse']))
		{
			$browse = 'A';
		} else {
			$browse = $_REQUEST['browse'];
		}

		$sections = FetchSections( 'Obsedb_Mods_sections' );
		$Mods = $db->Execute( "SELECT id,title,section
								FROM `Obsedb_Mods`
								WHERE `title` LIKE '" . $browse . "%'
								ORDER BY `title`;" );
		while ($row = $Mods->FetchNextObject())
		{
			echo '<tr><td style="font-size: 8pt;" class="formlabel">';

			echo '<a href="downloads.php?do=add&id='.$row->ID.'">[add download]</a> ';
			echo '<a href="downloads.php?do=manage&id='.$row->ID.'">[manage downloads]</a> &nbsp; &nbsp;';
			echo ' <b>'.clean($row->TITLE).'</b> ('.$sections["$row->SECTION"].')';

			echo '</td></tr>';
		}

		do_table_footer();
	}

	function manage()
	{
		global $db;
		$Mod = $db->Execute("SELECT id,title FROM `Obsedb_Mods` WHERE `id` = '{$_REQUEST['id']}';");
		do_table_header("Downloads: " . clean($Mod->fields['title']));

		$result = $db->Execute("SELECT id,title,Modid FROM `Obsedb_downloads` WHERE `Modid` = '{$_REQUEST['id']}' ORDER BY `title`;");
		while ($row = $result->FetchNextObject())
		{
			echo "<tr>
					<td style='font-size: 8pt;'>
					<a href=\"downloads.php?do=edit&id=$row->ID\">[edit download]</a>
					<a href=\"downloads.php?do=delete&id=$row->ID\">[delete]</a> &nbsp;
					" . clean($row->TITLE) . "
					</td>
				</tr>";
		}
	}

	function delete()
	{
		global $db;
		$db->Execute("DELETE FROM `Obsedb_downloads` WHERE `id` = '{$_REQUEST['id']}';");
		SPMessage('Success: Download has been deleted.',"downloads.php?do=manage&id={$_REQUEST['Modid']}");
	}

	function edit()
	{
		global $db;
		$result = $db->Execute("SELECT * FROM `Obsedb_downloads` WHERE `id` = '{$_REQUEST['id']}';");
		$formdata = array(

			'1' => array(

				'type' => 'text',
				'title' => 'Download Title',
				'name' => 'title',
				'value' => clean($result->fields['title'])

				),

			'2' => array(

				'type' => 'text',
				'title' => 'Download URL',
				'name' => 'download',
				'value' => stripslashes($result->fields['download'])

				),

			'3' => array(

				'type' => 'submit',
				'title' => 'Save Changes'

				)
			);

		$hidden = array(
			'id' => $_REQUEST['id']
			);

		GenerateForm('downloads.php','Edit Download','edit_download_confirm',$formdata,$hidden);
	}

	function add()
	{
		global $db;
        $result = $db->Execute("SELECT g.id,g.title,p.title AS `platform` FROM Obsedb_Mods AS g, Obsedb_Mods_sections AS p WHERE g.section = p.id ORDER BY g.title");
        $Mods['0'] = 'Select Mod';
        while ($row = $result->FetchNextObject())
        {
            $Mods[$row->ID] = stripslashes($row->TITLE) . " (" . stripslashes($row->PLATFORM) . ")";
        }
		$formdata = array(

            '4' => array(
                'type' => 'select',
                'title' => 'Mod',
                'name' => 'Modid',
                'value' => $Mods,
                'selected' => $_REQUEST['id']),

			'1' => array(

				'type' => 'text',
				'title' => 'Download Title',
				'name' => 'title',

				),

			'2' => array(

				'type' => 'text',
				'title' => 'Download URL',
				'name' => 'download'

				),

			'3' => array(

				'type' => 'submit',
				'title' => 'Add Download'

				)
			);

		$hidden = array(
			'Modid' => $_REQUEST['id']
			);

		GenerateForm('downloads.php','Add Download','add_download_confirm',$formdata,$hidden);
	}

	function add_confirm()
	{
		global $db;
		$rs = $db->Execute("SELECT * FROM `Obsedb_downloads` WHERE `id` = '0';");
		$record = array(
			'Modid' => $_REQUEST['Modid'],
			'title' => $_REQUEST['title'],
			'download' => $_REQUEST['download']
			);
		$sql = $db->GetInsertSQL($rs, $record);
		$db->Execute($sql);
		SPMessage('Success: Download has been added.','downloads.php');
	}

	function edit_confirm()
	{
		global $db;
		$rs = $db->Execute("SELECT * FROM `Obsedb_downloads` WHERE `id` = '{$_REQUEST['id']}';");
		$record = array(

			'title' => $_REQUEST['title'],
			'download' => $_REQUEST['download']
			);
		$sql = $db->GetUpdateSQL($rs, $record);
		$db->Execute($sql);
		SPMessage('Success: Changes have been saved.','downloads.php');
	}


}

?>