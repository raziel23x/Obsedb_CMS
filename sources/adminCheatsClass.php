<?php

class Module
{

    var $phrase;
    
    function initForm()
    {
        global $cp;
        
        $cp->header();
        $this->phrase = $cp->getPhrases( 'adminCheats' );
        $this->header();
        
        $do = $cp->getParam( 'do' );

        switch($do)
        {
	        case 'add':
		        $this->add();
		        break;
	        case 'add_confirm':
		        $this->add_confirm();
		        break;
	        case 'delete':
		        $this->delete();
		        break;
	        case 'edit':
		        $this->edit();
		        break;
	        case 'edit_confirm':
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
		$links = "<a href=cheats.php>" . $this->phrase['manage_cheats'] . "</a> | ";
		$links .= "<a href=\"cheats.php?do=add\">" . $this->phrase['add_cheat'] . "</a>";
		do_module_header($this->phrase['cheats_header'],$links);
	}

	function main()
	{

		global $db;

		do_table_header('Cheats');

		echo "<tr><td class=\"formlabel\" colspan=\"2\"><b>";
		$alpha = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9','0');
		foreach($alpha AS $value)
		{
			echo "<a href=\"cheats.php?browse=$value\">$value</a> &nbsp;";
		}
		echo "</b></td></tr>";

		if (empty($_REQUEST['browse']))
		{
			$browse = 'A';
		}
		else
		{
			$browse = $_REQUEST['browse'];
		}

		$sections = FetchSections('Obsedb_Mods_sections');

		$result = $db->Execute("SELECT id,title,section
					FROM `Obsedb_Mods`
					WHERE `title` LIKE '" . $browse . "%'
					ORDER BY `title`;") or die($db->ErrorMsg());

		while ($row = $result->FetchNextObject())
		{
			echo '<tr><td style="font-size: 8pt;" class="formlabel">';
			echo ' <b>'.clean($row->TITLE).'</b> ('.$sections["$row->SECTION"].')</td><td align="right" class="formlabel">';
			echo '<a href="cheats.php?do=add&id='.$row->ID.'">'.$this->phrase['add_cheat'].'</a> | ';
			echo '<a href="cheats.php?do=manage&id='.$row->ID.'">'.$this->phrase['manage_cheats'].'</a>';
			echo '</td></tr>';
		}

		do_table_footer();
	}

	function manage()
	{
		global $db;

		$result = $db->Execute("SELECT id,title
					FROM `Obsedb_Mods`
					WHERE `id` = '{$_REQUEST['id']}';");

		do_table_header("Cheats: " . clean($result->fields['title']));

		$result = $db->Execute("SELECT id,title,Modid
					FROM `Obsedb_cheats`
					WHERE `Modid` = '{$_REQUEST['id']}'
					ORDER BY `title`;");

		echo '<tr><td style="font-size: 8pt;" class="formlabel">';
		if ( $result->RecordCount() == 1 )
		{
			echo '<b>There is 1 cheat for this Mod.</b>';
		}
		else
		{
			echo '<b>There are ' . $result->RecordCount() . ' cheats for this Mod.</b>';
		}
		echo '</td></tr>';

		while ($row = $result->FetchNextObject())
		{
			echo "<tr>
					<td style='font-size: 8pt;' class='formlabel'>
					<a href=\"cheats.php?do=edit&id=$row->ID\">[edit cheat]</a>
					<a href=\"cheats.php?do=delete&id=$row->ID\">[delete]</a> &nbsp;
					" . clean($row->TITLE) . "
					</td>
				</tr>";
		}
		
		do_table_footer();
	}

	function delete()
	{
		global $db;

		$db->Execute("DELETE FROM `Obsedb_cheats`
				WHERE `id` = '{$_REQUEST['id']}';");

		SPMessage('Success: Cheat has been deleted.',"cheats.php?do=manage&id={$_REQUEST['id']}");
	}

	function edit()
	{
		global $db;

		$result = $db->Execute("SELECT * FROM `Obsedb_cheats`
					WHERE `id` = '{$_REQUEST['id']}';");

		$formdata = array(

			'1' => array(

				'type' => 'text',
				'title' => 'Cheat Title',
				'name' => 'title',
				'value' => clean($result->fields['title'])

				),

			'2' => array(

				'type' => 'textarea',
				'title' => 'Cheat Text',
				'name' => 'cheat',
				'value' => clean($result->fields['cheat'])

				),

			'3' => array(

				'type' => 'submit',
				'title' => 'Save Changes'

				)
			);

		$hidden = array(
			'id' => $_REQUEST['id']
			);

		GenerateForm('cheats.php','Edit Cheat','edit_confirm',$formdata,$hidden);
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
		
		    '1' => array(
		        
		        'type' => 'select',
		        'title' => 'Mod',
		        'name' => 'Modid',
		        'value' => $Mods,
		        'selected' => $_REQUEST['id']
		        
		        ),

			'2' => array(

				'type' => 'text',
				'title' => 'Cheat Title',
				'name' => 'title',

				),

			'3' => array(

				'type' => 'textarea',
				'title' => 'Cheat Text',
				'name' => 'cheat'

				),

			'4' => array(

				'type' => 'submit',
				'title' => 'Add Cheat'

				)
			);

		GenerateForm('cheats.php','Add Cheat','add_confirm',$formdata);
	}

	function add_confirm()
	{
		global $db;

		$rs = $db->Execute("SELECT * FROM `Obsedb_cheats`
					WHERE `id` = '0';");
		$record = array(

			'Modid' => $_REQUEST['Modid'],
			'title' => $_REQUEST['title'],
			'cheat' => $_REQUEST['cheat'],

			);

		$sql = $db->GetInsertSQL($rs, $record);
		$db->Execute($sql);

		SPMessage('Success: Cheat has been added.','cheats.php');
	}

	function edit_confirm()
	{
		global $db;

		$rs = $db->Execute("SELECT * FROM `Obsedb_cheats`
					WHERE `id` = '{$_REQUEST['id']}';");

		$record = array(

			'title' => $_REQUEST['title'],
			'cheat' => $_REQUEST['cheat'],

			);

		$sql = $db->GetUpdateSQL($rs, $record);
		$db->Execute($sql);

		SPMessage('Success: Changes have been saved.','cheats.php');
	}


}

?>