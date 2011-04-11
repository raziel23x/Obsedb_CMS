<?php

function manage_Mods()
{

	global $db, $LANG, $spconfig;

	$spSections = FetchSections('Obsedb_Mods_sections');

	do_form_header( 'Mods.php' );
	do_table_header( $LANG['filter'] );
	echo '
		<tr>
			<td class="formlabel" align="right">
			<select name="s">
			<option value="0">' . $LANG['selectsection'] . '</option>';

	foreach ( $spSections AS $key => $value )
	{
		if ($_REQUEST['s'] == $key)
		{
			echo '<option value="' . $key . '" selected>' . stripslashes($value) . '</option>';
		} else {
			echo '<option value="' . $key . '">' . stripslashes($value) . '</option>';
		}
	}


	echo '
			</select>
			<input type="submit" name="submit" value="' . $LANG['go'] . '">
			</td>
		</tr>';
	do_table_footer();
	do_form_footer();

	do_form_header( "Mods.php" );
	do_table_header( $LANG['Mods'] );

	echo '
		<tr>
			<td class="formlabel"><strong>' . $LANG['title'] . '</strong></td>
			<td class="formlabel"><strong>' . $LANG['section'] . '</strong></td>';

	if ($spconfig['Mod_tools'] == 1)
	{
		echo '
			<td class="formlabel"><strong>' . $LANG['tools'] . '</strong></td>';
	}

	echo '
		</tr>';

	if ( isset($_REQUEST['s']) && ($_REQUEST['s'] != '') )
	{
	    if (empty($_REQUEST['page']))
	    {
		    $page = 0;
	    } else {
		    $page = $_REQUEST['page'];
	    }

	    $result = $db->Execute("SELECT id FROM `Obsedb_Mods` WHERE `section` = '{$_REQUEST['s']}'");
	    $total = $result->RecordCount();

	    if ($total >= 11)
	    {
		    $limit = $page * 10;
	    } else {
		    $limit = 0;
	    }
		$latestMod = $db->Execute("SELECT id,title,section,published FROM `Obsedb_Mods` WHERE `section` = '$_REQUEST[s]' ORDER BY `title` LIMIT $limit, 10");

	} else {

		if (!empty($_REQUEST['title']))
		{
	        if (empty($_REQUEST['page']))
	        {
		        $page = 0;
	        } else {
		        $page = $_REQUEST['page'];
	        }

	        $result = $db->Execute("SELECT id FROM `Obsedb_Mods` WHERE `title` LIKE '%" . $_REQUEST['title'] . "%'");
	        $total = $result->RecordCount();

	        if ($total >= 11)
	        {
		        $limit = $page * 10;
	        } else {
		        $limit = 0;
	        }
			$latestMod = $db->Execute("SELECT id,title,section,published FROM `Obsedb_Mods` WHERE `title` LIKE '%" . $_REQUEST['title'] . "%' ORDER BY `title` LIMIT $limit, 10; ");
		} else {
	        if (empty($_REQUEST['page']))
	        {
		        $page = 0;
	        } else {
		        $page = $_REQUEST['page'];
	        }

	        $result = $db->Execute("SELECT id FROM `Obsedb_Mods`");
	        $total = $result->RecordCount();

	        if ($total >= 11)
	        {
		        $limit = $page * 10;
	        } else {
		        $limit = 0;
	        }
			$latestMod = $db->Execute("SELECT id,title,section,published FROM `Obsedb_Mods` ORDER BY `id` DESC LIMIT $limit, 10");
		}

	}

		while ( $row = $latestMod->FetchNextObject() )
		{
			$bgcolor = ($bgcolor == '#ECECFF' ? '#FFFFFF' : '#ECECFF');
			echo "
				<tr>
					<td style=\"background-color: $bgcolor; font-size: 11px;\">
					<input type=\"radio\" name=\"id\" value=\"$row->ID\">";

			if ($row->PUBLISHED == 0)
			{
				echo "<font style=\"color: #C0C0C0;\">";
			}
			if ($row->PUBLISHED == 0)
			{
				echo " <a href='Mods.php?do=publish&id=$row->ID'><img src='../images/user/unpublished.jpg' border='0'></a> &nbsp;";
			}
			if ($row->PUBLISHED == 1)
			{
				echo " <a href='Mods.php?do=unpublish&id=$row->ID'><img src='../images/user/published.jpg' border='0'></a> &nbsp;";
			}
			echo(clean($row->TITLE));

			echo("</TD>");
			echo("<TD BGCOLOR='$bgcolor'>");
			if ($row->PUBLISHED == 0)
			{
				echo "<font style=\"color: #C0C0C0;\">";
			}
			echo($spSections["$row->SECTION"]);
			echo '</td>';


			if ($spconfig['Mod_tools'] == 1)
			{
				if ($spconfig['Mod_tools_popups'] == 1)
				{
					$target = "target=\"_blank\"";
				}
				echo '
					<td style="background-color: '.$bgcolor.';">
						<a href="cheats.php?do=add&id=', $row->ID, '" ', $target, '>
						<img src="../images/user/addCheat.jpg" alt="', $LANG['content_cheat'], '" border="0">
						</a>
						&nbsp;
						<a href="downloads.php?do=add&id=', $row->ID, '"' , $target, '>
						<img src="../images/user/addDownload.jpg" alt="', $LANG['content_download'], '" border="0">
						</a>
					</td>';
			}

			echo("</TR>");
			}
		echo '<tr>
				<td colspan="3" class="formlabel">
					<input type="submit" name="do" value="'.$LANG['edit_Mod'].'">
					<input type="submit" name="do" value="'.$LANG['delete_Mod'].'">
					<input type="submit" name="do" value="'.$LANG['view_matrix'].'">
				</td>
			  </tr>';
		do_table_footer();

		if ($total >= 10)
		{
			$pages = $total / 10;
			do_table_header( $LANG['pages'] );
			echo('<tr><td class="formlabel">');
			for ($y = 0; $y < $pages; $y++)
			{
				if ($y == $_REQUEST['page'])
				{
					echo " <strong>$y</strong> &nbsp;";
				} else {
					echo " <a href=\"Mods.php?page=$y&s={$_REQUEST['s']}\">$y</a> &nbsp;";
				}
			}
			echo('</td></tr>');
			do_table_footer();
		}

		do_form_footer();

}


function add_section_confirm()
{
	global $db, $LANG;
	$db->Execute("INSERT INTO `Obsedb_Mods_sections` (title) VALUES ('$_REQUEST[title]');");
	SPMessage($LANG['add_section_confirm'],'Mods.php');
}

function manage_sections()
{
	global $db, $LANG;
	do_form_header('Mods.php');
	do_table_header($LANG['sections']);

	$result = $db->Execute("SELECT id,title FROM `Obsedb_Mods_sections` ORDER BY `title`");
	while ($row = $result->FetchNextObject()) {
		$bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");
		echo '<tr><td bgcolor="'.$bgcolor.'" colspan="2"><input type="radio" value="'.$row->ID.'" name="id"> '.stripslashes($row->TITLE).'</td></tr>';
		}
	echo '<tr>
			<td colspan="2" class="formlabel">
				<input type="submit" name="do" value="'.$LANG['edit_section'].'">
				<input type="submit" name="do" value="'.$LANG['delete_section'].'">
			</td>
		  </tr>';
	do_table_footer();
	do_form_footer();

	echo $LANG['warning'];

}

function add_Mod()
{
	global $db, $LANG;
	$sections = FetchSections( 'Obsedb_Mods_sections' );
	$companies = FetchSections( 'Obsedb_companies' );
	$esrb = array(
		'N/A' => 'N/A',
		'RP - Rating Pending' => 'RP - Rating Pending',
		'EC - Early Childhood' => 'EC - Early Childhood',
		'E - Everyone' => 'E - Everyone',
                'E10+ - Everyone 10+' => 'E10+ - Everyone 10+',
		'T - Teen' => 'T - Teen',
		'M - Mature' => 'M - Mature',
		'AO - Adults Only' => 'AO - Adults Only'
		);
	$coop = array(
		'Unknown' => 'Unknown',
		'No' => 'No',
		'Yes' => 'Yes'
		);

	$form = array(
		'1' => array('type' => 'text', 'title' => $LANG['title'], 'name' => 'title'),
		'2' => array('type' => 'select', 'title' => $LANG['section'], 'name' => 'section', 'value' => $sections),
		'3' => array('type' => 'select', 'title' => $LANG['developer'], 'name' => 'developer', 'value' => $companies),
		'4' => array('type' => 'select', 'title' => $LANG['publisher'], 'name' => 'publisher', 'value' => $companies),
		'5' => array('type' => 'select', 'title' => $LANG['esrb_rating'], 'name' => 'esrb', 'value' => $esrb),
		'6' => array('type' => 'text', 'title' => $LANG['genre'], 'name' => 'genre'),
		'7' => array('type' => 'text', 'title' => $LANG['release_date'], 'name' => 'release_date'),
		'8' => array('type' => 'text', 'title' => $LANG['multiplayer'], 'name' => 'multiplayer'),
		'9' => array('type' => 'text', 'title' => $LANG['boxshot'], 'name' => 'boxshot'),
		'10' => array('type' => 'select', 'title' => $LANG['coop'], 'name' => 'coop', 'value' => $coop),
		'22' => array('type' => 'submit', 'title' => 'Add Mod'),
		'11' => array('type' => 'textarea', 'title' => $LANG['description'], 'name' => 'description'),
		'12' => array('type' => 'spacer', 'title' => $LANG['minimum']),
		'13' => array('type' => 'text', 'title' => $LANG['system'], 'name' => 'req_system'),
		'14' => array('type' => 'text', 'title' => $LANG['ram'], 'name' => 'req_ram'),
		'15' => array('type' => 'text', 'title' => $LANG['video_memory'], 'name' => 'req_video'),
		'16' => array('type' => 'text', 'title' => $LANG['harddrive'], 'name' => 'req_space'),
		'17' => array('type' => 'text', 'title' => $LANG['mouse'], 'name' => 'req_mouse'),
		'18' => array('type' => 'text', 'title' => $LANG['directx'], 'name' => 'req_directx'),
		'19' => array('type' => 'text', 'title' => $LANG['sound'], 'name' => 'req_sound'),
		'20' => array('type' => 'spacer', 'title' => 'Upload Box Art'),
		'21' => array('type' => 'file', 'title' => 'Image', 'name' => 'image')
	);

	$result = $db->Execute("SELECT * FROM Obsedb_customfields WHERE module = 'Mods' ORDER BY title;");
	while ($row = $result->FetchNextObject())
	{
		$form[] = array('type' => $row->TYPE, 'title' => $row->TITLE, 'name' => "field$row->ID");
	}

	$form[] = array('type' => 'submit', 'title' => $LANG['add_Mod']);

	GenerateForm('Mods.php',$LANG['new_Mod'],'add_Mod_confirm',$form,'','true');

}

function edit_section_confirm()
{
	global $db, $LANG;
	$rs = $db->Execute("SELECT * FROM `Obsedb_Mods_sections` WHERE `id` = '$_REQUEST[id]'");
	$record = array(
		'title' => $_REQUEST['title']
		);
	$sql = $db->GetUpdateSQL($rs, $record);
	$db->Execute($sql);
	SPMessage($LANG['edit_section_confirm'],'Mods.php');

}

function add_Mod_confirm()
{
	global $db, $LANG, $PATH_TRANSLATED;
	if ( isset($_FILES["image"]["name"]) && ($_FILES["image"]["name"] != "") )
	{
	    do_table_header("Upload Detected, Debug Information");
	    do_blank_row( "File name: " . $_FILES["image"]["name"] );
	    do_blank_row( "File type: " . $_FILES["image"]["type"] );
	    do_table_footer();
	    
	    $CurBasePath = dirname( $PATH_TRANSLATED );
	    $CurBasePath = str_replace( "/user", "/media/boxart/", $CurBasePath );
	    if ( ( $_FILES["image"]["type"] == "image/gif" ) ||
	         ( $_FILES["image"]["type"] == "image/pjpeg" ) ||
	         ( $_FILES["image"]["type"] == "image/jpeg" ) )
	    {
	        $image_name = str_replace( " ", "-", $_FILES["image"]["name"] );
	        $NewName = $CurBasePath . $image_name;
	        copy( $_FILES["image"]["tmp_name"], $NewName )
	            or die("Could not upload box art to $NewName");
	        $_REQUEST["boxshot"] = "media/boxart/" . $_FILES["image"]["name"];
	    }
	    
	}
	
	
	
	$rs = $db->Execute("
		SELECT
			*
		FROM
			Obsedb_Mods AS g
		WHERE
			g.id = '-1'");

	$record = array(
		'title' => $_REQUEST['title'],
		'section' => $_REQUEST['section'],
		'description' => $_REQUEST['description'],
		'developer' => $_REQUEST['developer'],
		'publisher' => $_REQUEST['publisher'],
		'genre' => $_REQUEST['genre'],
		'release_date' => $_REQUEST['release_date'],
		'multiplayer' => $_REQUEST['multiplayer'],
		'boxshot' => $_REQUEST['boxshot'],
		'esrb' => $_REQUEST['esrb'],
		'coop' => $_REQUEST['coop'],
		'req_system' => $_REQUEST['req_system'],
		'req_ram' => $_REQUEST['req_ram'],
		'req_video' => $_REQUEST['req_video'],
		'req_space' => $_REQUEST['req_space'],
		'req_mouse' => $_REQUEST['req_mouse'],
		'req_directx' => $_REQUEST['req_directx'],
		'req_sound' => $_REQUEST['req_sound'],
		'published' => '1'
		);
	$sql = $db->GetInsertSQL($rs, $record);
	$db->Execute($sql) or die(SPMessage($db->ErrorMsg()));
	$Mod = $db->Execute("SELECT id FROM Obsedb_Mods ORDER BY id DESC LIMIT 1");
	$result = $db->Execute("SELECT * FROM Obsedb_customfields WHERE module = 'Mods' ORDER BY title;");
	while ($row = $result->FetchNextObject())
	{
			$db->Execute("INSERT INTO Obsedb_Mods_customdata (Modid,fieldid,value) VALUES ('".$Mod->fields['id']."','$row->ID','".$_REQUEST["field" . $row->ID]."');");
	}
	

	
	SPMessage($LANG['add_Mod_confirm'],'Mods.php');


}

function do_sections_row($sel='') {
	global $db, $LANG;
	$result = $db->Execute("SELECT id,title FROM `Obsedb_Mods_sections` ORDER BY `title`");

	echo '<tr><td class="formlabel" colspan="2"><select name="section">';

	echo '<option value="null">'.$LANG['selectsection'].'</option>';

	while ($row = $result->FetchNextObject()) {

		if ($row->ID == $sel) {
			echo '<option value="' . $row->ID . '" selected>' . stripslashes($row->TITLE) . '</option>\n';
		} else {
			echo '<option value="' . $row->ID . '">' . stripslashes($row->TITLE) . '</option>\n';
		}



	}

	echo '</select></td></tr>';

	}

function do_developer_row($sel='') {
	global $db, $LANG;
	$result = $db->Execute("SELECT id,title FROM `Obsedb_companies` ORDER BY `title`");

	echo '<tr><td class="formlabel" colspan="2"><select name="developer">';

	echo '<option value="null">'.$LANG['selectdeveloper'].'</option>';

	while ($row = $result->FetchNextObject()) {

		if ($row->ID == $sel) {
			echo '<option value="' . $row->ID . '" selected>' . stripslashes($row->TITLE) . '</option>\n';
		} else {
			echo '<option value="' . $row->ID . '">' . stripslashes($row->TITLE) . '</option>\n';
		}



	}

	echo '</select></td></tr>';

	}

function do_publisher_row($sel='') {
	global $db, $LANG;
	$result = $db->Execute("SELECT id,title FROM `Obsedb_companies` ORDER BY `title`");

	echo '<tr><td class="formlabel" colspan="2"><select name="publisher">';

	echo '<option value="null">'.$LANG['selectpublisher'].'</option>';

	while ($row = $result->FetchNextObject()) {

		if ($row->ID == $sel) {
			echo '<option value="' . $row->ID . '" selected>' . stripslashes($row->TITLE) . '</option>\n';
		} else {
			echo '<option value="' . $row->ID . '">' . stripslashes($row->TITLE) . '</option>\n';
		}



	}

	echo '</select></td></tr>';

	}


class Module {

	function add_quick_confirm()
	{
		global $db, $LANG;
		$rs = $db->Execute("SELECT id, title, section, published
							FROM `Obsedb_Mods`
							WHERE `id` = '-1'");

		$record = array(
			'1' => $_REQUEST['title1'],
			'2' => $_REQUEST['title2'],
			'3' => $_REQUEST['title3'],
			'4' => $_REQUEST['title4'],
			'5' => $_REQUEST['title5'],
			'6' => $_REQUEST['title6'],
			'7' => $_REQUEST['title7'],
			'8' => $_REQUEST['title8'],
			'9' => $_REQUEST['title9'],
			'10' => $_REQUEST['title10']);

		foreach ($record AS $Mod)
		{
			if (!empty($Mod))
			{
				$db->Execute("INSERT INTO Obsedb_Mods (title,section,published) VALUES ('$Mod','{$_REQUEST['section']}','1');");
			}
		}

		SPMessage($LANG['add_quick_confirm'],"Mods.php");
	}

	function add_quick()
	{
		global $db, $LANG;
		do_form_header('Mods.php');
		do_table_header($LANG['quick_add']);
		do_text_row($LANG['title'],'title1');
		do_text_row($LANG['title'],'title2');
		do_text_row($LANG['title'],'title3');
		do_text_row($LANG['title'],'title4');
		do_text_row($LANG['title'],'title5');
		do_text_row($LANG['title'],'title6');
		do_text_row($LANG['title'],'title7');
		do_text_row($LANG['title'],'title8');
		do_text_row($LANG['title'],'title9');
		do_text_row($LANG['title'],'title10');
		$sections = FetchSections('Obsedb_Mods_sections');
		do_select_row($LANG['section'],'section',$sections);
		do_submit_row($LANG['add_Mod']);
		do_table_footer();
		echo '<input type="hidden" name="do" value="add_quick_confirm">';
		echo '<input type="hidden" name="developer" value="0">';
		echo '<input type="hidden" name="publisher" value="0">';
		do_form_footer();
	}

	function delete_Mod()
	{
		global $db, $LANG, $PATH_TRANSLATED;
        $result = $db->Execute("
            SELECT * FROM Obsedb_Mods 
            WHERE `id` = '$_REQUEST[id]'");
            
        $path = $PATH_TRANSLATED;
        $path = str_replace( "/user/Mods.php", "/", $path );
        unlink( $path . $result->fields['boxshot']);
		$db->Execute("DELETE FROM `Obsedb_Mods` WHERE `id` = '$_REQUEST[id]'");
		SPMessage($LANG['delete_Mod'],'Mods.php');
	}

	function delete_section()
	{
		global $db, $LANG;
		$db->Execute("DELETE FROM `Obsedb_Mods_sections` WHERE `id` = '$_REQUEST[id]'");
		$db->Execute("DELETE FROM `Obsedb_Mods` WHERE `section` = '" . $_REQUEST['id'] . "';");
		SPMessage($LANG['delete_section_confirm'],'Mods.php');
	}

	function publish()
	{
		global $db, $LANG;
		$db->Execute("UPDATE `Obsedb_Mods`
					 SET `published` = '1'
					 WHERE `id` = '{$_REQUEST['id']}'");
		SPMessage($LANG['publish_confirm'],'Mods.php');
	}

	function unpublish()
	{
		global $db, $LANG;
		$db->Execute("UPDATE `Obsedb_Mods`
					  SET `published` = '0'
					  WHERE `id` = '{$_REQUEST['id']}'");
		SPMessage($LANG['unpublish_confirm'],'Mods.php');
	}

	function view_matrix()
	{
		global $LANG;
		SPMessage( $LANG['load_matrix'], "rcm_matrix.php?do=viewmatrix&type=Mods&id={$_REQUEST['id']}" );
	}


	function search_Mods()
	{
		global $db, $LANG;
		do_form_header( "Mods.php" );
		do_table_header( $LANG['search'] );
		do_text_row( $LANG['search_title'], "title" );
		do_submit_row( $LANG['go'] );
		do_table_footer();
		do_form_footer();
	}

	function edit_Mod()
	{
		global $db, $LANG;
		$Mod = $db->Execute("SELECT * FROM `Obsedb_Mods` WHERE `id` = '$_REQUEST[id]';");
		$row = $Mod->FetchNextObject();
		$sections = FetchSections( 'Obsedb_Mods_sections' );
		$companies = FetchSections( 'Obsedb_companies' );
		$esrb = array(
			'N/A' => 'N/A',
			'RP - Rating Pending' => 'RP - Rating Pending',
			'EC - Early Childhood' => 'EC - Early Childhood',
			'E - Everyone' => 'E - Everyone',
                        'E10+ - Everyone 10+' => 'E10+ - Everyone 10+',
			'T - Teen' => 'T - Teen',
			'M - Mature' => 'M - Mature',
			'AO - Adults Only' => 'AO - Adults Only'
			);
		$coop = array(
			'Unknown' => 'Unknown',
			'No' => 'No',
			'Yes' => 'Yes'
			);
		$form = array(
			'1' => array(
				'type' => 'text',
				'title' => $LANG['title'],
				'name' => 'title',
				'value' => stripslashes($row->TITLE)),
			'2' => array(
				'type' => 'select',
				'title' => $LANG['section'],
				'name' => 'section',
				'value' => $sections,
				'selected' => $row->SECTION),
			'3' => array(
				'type' => 'select',
				'title' => $LANG['developer'],
				'name' => 'developer',
				'value' => $companies,
				'selected' => $row->DEVELOPER),
			'4' => array(
				'type' => 'select',
				'title' => $LANG['publisher'],
				'name' => 'publisher',
				'value' => $companies,
				'selected' => $row->PUBLISHER),
			'5' => array(
				'type' => 'select',
				'title' => $LANG['esrb_rating'],
				'name' => 'esrb',
				'value' => $esrb,
				'selected' => $row->ESRB),
			'6' => array(
				'type' => 'text',
				'title' => $LANG['genre'],
				'name' => 'genre',
				'value' => stripslashes($row->GENRE)),
			'7' => array(
				'type' => 'text',
				'title' => $LANG['release_date'],
				'name' => 'release_date',
				'value' => stripslashes($row->RELEASE_DATE)),
			'8' => array(
				'type' => 'text',
				'title' => $LANG['multiplayer'],
				'name' => 'multiplayer',
				'value' => stripslashes($row->MULTIPLAYER)),
			'9' => array(
				'type' => 'text',
				'title' => $LANG['boxshot'],
				'name' => 'boxshot',
				'value' => stripslashes($row->BOXSHOT)),
			'10' => array(
				'type' => 'select',
				'title' => $LANG['coop'],
				'name' => 'coop',
				'value' => $coop,
				'selected' => $row->COOP),
			'11' => array(
				'type' => 'textarea',
				'title' => $LANG['description'],
				'name' => 'description',
				'value' => $row->DESCRIPTION),
			'12' => array(
				'type' => 'spacer',
				'title' => $LANG['minimum']),
			'13' => array(
				'type' => 'text',
				'title' => $LANG['system'],
				'name' => 'req_system',
				'value' => stripslashes($row->REQ_SYSTEM)),
			'14' => array(
				'type' => 'text',
				'title' => $LANG['ram'],
				'name' => 'req_ram',
				'value' => stripslashes($row->REQ_RAM)),
			'15' => array(
				'type' => 'text',
				'title' => $LANG['video_memory'],
				'name' => 'req_video',
				'value' => stripslashes($row->REQ_VIDEO)),
			'16' => array(
				'type' => 'text',
				'title' => $LANG['harddrive'],
				'name' => 'req_space',
				'value' => stripslashes($row->REQ_SPACE)),
			'17' => array(
				'type' => 'text',
				'title' => $LANG['mouse'],
				'name' => 'req_mouse',
				'value' => stripslashes($row->REQ_MOUSE)),
			'18' => array(
				'type' => 'text',
				'title' => $LANG['directx'],
				'name' => 'req_directx',
				'value' => stripslashes($row->REQ_DIRECTX)),
			'19' => array(
				'type' => 'text',
				'title' => $LANG['sound'],
				'name' => 'req_sound',
				'value' => stripslashes($row->REQ_SOUND)),
		'20' => array('type' => 'spacer', 'title' => 'Upload Box Art'),
		'23' => array('type' => 'blank', 'title' => 'This will overwrite your current boxart.'),
		'21' => array('type' => 'file', 'title' => 'Image', 'name' => 'image'),
		'22' => array('type' => 'spacer', 'title' => 'Custom Fields')
		);
		$result = $db->Execute("SELECT * FROM Obsedb_customfields WHERE module = 'Mods' ORDER BY title;");
		while ($row = $result->FetchNextObject())
		{
			$field = $db->Execute("SELECT * FROM Obsedb_Mods_customdata WHERE Modid = $_REQUEST[id] AND fieldid = $row->ID;");
			$form[] = array('type' => $row->TYPE, 'title' => $row->TITLE, 'name' => "field$row->ID", 'value' => stripslashes($field->fields['value']));
		}
		$form[] = array('type' => 'submit', 'title' => 'Save Mod');
		$hidden = array('id' => $_REQUEST['id']);
		GenerateForm('Mods.php',$LANG['edit_Mod'],'edit_Mod_confirm',$form, $hidden, 'true');
	}

	function save_Mod()
	{
	    global $db, $LANG, $PATH_TRANSLATED;
	    if ( isset($_FILES["image"]["name"]) && ($_FILES["image"]["name"] != "") )
	    {
            $result = $db->Execute("
                SELECT * FROM Obsedb_Mods 
                WHERE `id` = '$_REQUEST[id]'");
                
            $path = $PATH_TRANSLATED;
            $path = str_replace( "/user/Mods.php", "/", $path );
            unlink( $path . $result->fields['boxshot']);
	        // do_table_header("Upload Detected, Debug Information");
	        // do_blank_row( "File name: " . $_FILES["image"]["name"] );
	        // do_blank_row( "File type: " . $_FILES["image"]["type"] );
	        // do_table_footer();
    	    
	        $CurBasePath = dirname( $PATH_TRANSLATED );
	        $CurBasePath = str_replace( "/user", "/media/boxart/", $CurBasePath );
	        if ( ( $_FILES["image"]["type"] == "image/gif" ) ||
	             ( $_FILES["image"]["type"] == "image/pjpeg" ) ||
	             ( $_FILES["image"]["type"] == "image/jpeg" ) )
	        {
	            $image_name = str_replace( " ", "-", $_FILES["image"]["name"] );
	            $NewName = $CurBasePath . $image_name;
	            copy( $_FILES["image"]["tmp_name"], $NewName )
	                or die("Could not upload box art to $NewName");
	            $_REQUEST["boxshot"] = "media/boxart/" . $_FILES["image"]["name"];
	        }
    	    
	    }
		$record = array(
			'title' => $_REQUEST['title'],
			'section' => $_REQUEST['section'],
			'description' => $_REQUEST['description'],
			'developer' => $_REQUEST['developer'],
			'publisher' => $_REQUEST['publisher'],
			'genre' => $_REQUEST['genre'],
			'release_date' => $_REQUEST['release_date'],
			'multiplayer' => $_REQUEST['multiplayer'],
			'boxshot' => $_REQUEST['boxshot'],
			'esrb' => $_REQUEST['esrb'],
			'coop' => $_REQUEST['coop'],
			'req_system' => $_REQUEST['req_system'],
			'req_ram' => $_REQUEST['req_ram'],
			'req_video' => $_REQUEST['req_video'],
			'req_space' => $_REQUEST['req_space'],
			'req_mouse' => $_REQUEST['req_mouse'],
			'req_directx' => $_REQUEST['req_directx'],
			'req_sound' => $_REQUEST['req_sound']
			);

		$db->AutoExecute('Obsedb_Mods',$record,'UPDATE',"id = $_REQUEST[id]");

		$result = $db->Execute("SELECT * FROM Obsedb_customfields WHERE module = 'Mods' ORDER BY title;");
		while ($row = $result->FetchNextObject())
		{
			$dataquery = $db->Execute("SELECT * FROM Obsedb_Mods_customdata WHERE Modid = $_REQUEST[id] AND fieldid = $row->ID LIMIT 1;");
			if ($dataquery->RecordCount() > 0)
			{
				$db->Execute("UPDATE Obsedb_Mods_customdata
					SET value = '" . $_REQUEST["field" . $row->ID] . "'
					WHERE id = " . $dataquery->fields['id'] . " AND Modid = $_REQUEST[id]");
			} else {
				$db->Execute("INSERT INTO Obsedb_Mods_customdata (Modid,fieldid,value) VALUES ('$_REQUEST[id]','$row->ID','".$_REQUEST["field" . $row->ID]."');");
			}
		}

		SPMessage($LANG['edit_Mod_confirm'],'Mods.php?');
	}

	function add_section()
	{
		global $db, $LANG;
		echo '<form method="post" action="Mods.php">';
		do_table_header($LANG['add_section']);
		do_text_row($LANG['title'],"title");
		do_submit_row();
		echo '<input type="hidden" name="do" value="add_section_confirm">';
		do_table_footer();
		echo '</form>';
	}

	function edit_section()
	{
		global $db, $LANG;
		$section = $db->Execute("SELECT * FROM `Obsedb_Mods_sections` WHERE `id` = '$_REQUEST[id]'");
		echo '<form method="post" action="Mods.php">';
		do_table_header($LANG['edit_section']);
		do_text_row($LANG['title'],"title",clean($section->fields['title']));
		do_submit_row($LANG['update']);
		echo '<input type="hidden" name="do" value="edit_section_confirm">';
		echo '<input type="hidden" name="id" value="' . $section->fields['id'] . '">';
		do_table_footer();
		echo '</form>';
	}

	function edit_settings()
	{
		global $db, $LANG, $spconfig;

		do_form_header('Mods.php');
		do_table_header($LANG['Mods_config']);

		$options = array('0' => $LANG['disabled'], '1' => $LANG['enabled']);

		do_select_row($LANG['show_tools'],'Mod_tools',$options,$spconfig['Mod_tools']);
		do_select_row($LANG['popup_tools'],'Mod_tools_popups',$options,$spconfig['Mod_tools_popups']);

		do_submit_row($LANG['save_settings']);
		do_table_footer();
		echo '<input type="hidden" name="do" value="save_settings">';
		do_form_footer();
	}

	function save_settings()
	{
		global $db, $LANG, $spconfig;
		$db->Execute("UPDATE Obsedb_configuration SET `value` = '{$_REQUEST['Mod_tools']}' WHERE `key` = 'Mod_tools'");
		$db->Execute("UPDATE Obsedb_configuration SET `value` = '{$_REQUEST['Mod_tools_popups']}' WHERE `key` = 'Mod_tools_popups'");
		SPMessage( $LANG['settings_success'], 'Mods.php' );
	}

}



?>