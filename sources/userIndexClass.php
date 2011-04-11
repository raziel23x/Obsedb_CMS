<?php

class Form 
{

    var $phrase;

    function initForm()
    {
        global $db, $cp, $spconfig;
        
        $do = $cp->getParam( 'do' );
        
        // Cache Phrases
        $this->phrase = $cp->getPhrases( "userIndex" );
        
        $cp->header();
        
        switch ($_REQUEST['do'])
        {
	        case 'add':
		        $this->addAnnouncementForm();
		        break;
	        case 'add_confirm':
		        $this->addAnnouncementCommit();
		        break;
	        case 'edit':
		        $this->editAnnouncementForm();
		        break;
	        case 'edit_confirm':
		        $this->editAnnouncementCommit();
		        break;
	        case 'delete':
		        $this->deleteAnnouncementCommit();
		        break;
	        default:
	            define('SUPPORTID','CPHOME');
		        $this->mainForm();
		        break;
        }
        
        $cp->footer();
        
    }

    function mainForm()
    {
	    global $db, $pwzlogin, $spconfig;

	    $links = '<a href="index2.php?do=add">Post Announcement</a>';

	    do_module_header( $this->phrase['welcome'] . $_SESSION['pwzlogin'], $links );

	    do_table_header( $this->phrase['announcements'] );
	    $result = $db->Execute("SELECT * FROM `Obsedb_announcements` ORDER BY `date` DESC;");
	    if ($result->RecordCount() == 0)
	    {
	        do_blank_row( $this->phrase['no_announcements'] );
	    }
	    while ($row = $result->FetchNextObject())
	    {
		    echo("<tr><td class='formlabel'><b>" . stripslashes($row->TITLE) . "</b><br />");
		    echo("Posted by " . stripslashes($row->USER) . " on " . stripslashes($row->DATE));
		    echo("<tr><td class='formlabel2'>" . html_entity_decode($row->TEXT) . "<br />");
		    echo("<font style='font-size: 11px; color: blue;'>");
		    echo("<a href=index2.php?do=edit&id=$row->ID>Edit Announcement</a> | ");
		    echo("<a href=index2.php?do=delete&id=$row->ID>Delete Announcement</a></td></tr>");
	    }
	    do_table_footer();

	    /**
	    *	Recent Mods Table
	    **/
	    
	    $cphome_recent_Mods = $spconfig['cphome_recent_Mods'];
	    
	    do_table_header( $this->phrase['recent_Mods'] );
	    $Mods = $db->Execute("SELECT id,title FROM `Obsedb_Mods` ORDER BY `id` DESC LIMIT 0,$cphome_recent_Mods");
	    while ($row = $Mods->FetchNextObject())
	    {
		    echo '
			    <tr>
				    <td class="formlabel" style="font-size: 11px;">
				    <a href="Mods.php?do=Edit Mod&id=', $row->ID, '">', stripslashes($row->TITLE), '</a>
				    </td>
			    </tr>';
	    }

	    if ($Mods->RecordCount() == 0)
	    {
		    do_blank_row( $this->phrase['no_content'] );
	    }
	    do_table_footer();

	    /**
	    *	Recent News Table
	    **/
	    do_table_header( $this->phrase['recent_news'] );
	    $news = $db->Execute("SELECT id,title FROM `Obsedb_news` ORDER BY `id` DESC LIMIT 0,5");
	    while ($row = $news->FetchNextObject())
	    {
		    echo '
			    <tr>
				    <td class="formlabel" style="font-size: 11px;">
				    <a href="news.php?do=Edit News&id=', $row->ID, '">', stripslashes($row->TITLE), '</a>
				    </td>
			    </tr>';
	    }
	    if ($news->RecordCount() == 0)
	    {
		    do_blank_row( $this->phrase['no_content'] );
	    }
	    do_table_footer();

	    /**
	    *	Recent Previews Table
	    **/
	    do_table_header( $this->phrase['recent_previews'] );
	    $previews = $db->Execute("SELECT id,title FROM `Obsedb_previews` ORDER BY `id` DESC LIMIT 0,5");
	    while ($row = $previews->FetchNextObject())
	    {
		    echo '
			    <tr>
				    <td class="formlabel" style="font-size: 11px;">
				    <a href="previews.php?do=Edit Preview&id=', $row->ID, '">', stripslashes($row->TITLE), '</a>
				    </td>
			    </tr>';
	    }
	    if ($previews->RecordCount() == 0)
	    {
		    do_blank_row( $this->phrase['no_content'] );
	    }
	    do_table_footer();

	    /**
	    * Recent Reviews Table
	    **/
	    do_table_header( $this->phrase['recent_previews'] );
	    $reviews = $db->Execute("SELECT id,title FROM `Obsedb_reviews` ORDER BY `id` DESC LIMIT 0,5");
	    while ($row = $reviews->FetchNextObject())
	    {
		    echo '
			    <tr>
				    <td class="formlabel" style="font-size: 11px;">
				    <a href="reviews.php?do=Edit Review&id=', $row->ID, '">', stripslashes($row->TITLE), '</a>
				    </td>
			    </tr>';
	    }
	    if ($reviews->RecordCount() == 0)
	    {
		    do_blank_row( $this->phrase['no_content'] );
	    }
	    do_table_footer();

    }
    
    
    
    function addAnnouncementForm()
    {
	    global $db, $pwzlogin;
	    do_form_header('index2.php');
	    do_table_header($this->phrase['post_announcement']);
	    do_text_row($this->phrase['username'],'user',$pwzlogin);
	    do_text_row($this->phrase['title'],'title');
	    do_textarea_row($this->phrase['message'],'text');
	    do_submit_row($this->phrase['post_announcement']);
	    do_table_footer();
	    echo '<input type="hidden" name="do" value="add_confirm">';
	    echo '</form>';
    }
    
    
    
    function editAnnouncementForm()
    {
	    global $db;
	    $result = $db->Execute("SELECT * FROM `Obsedb_announcements` WHERE `id` = '$_REQUEST[id]'");
	    do_form_header('index2.php');
	    do_table_header('Edit Announcement');
	    do_text_row($this->phrase['username'],'user',$result->fields['user']);
	    do_text_row($this->phrase['title'],'title',stripslashes($result->fields['title']));
	    do_textarea_row($this->phrase['message'],'text',stripslashes($result->fields['text']));
	    do_submit_row('Save Changes');
	    do_table_footer();
	    echo '<input type="hidden" name="do" value="edit_confirm">';
	    echo '<input type="hidden" name="id" value="'.$_REQUEST[id].'">';
	    echo '</form>';
    }
    
    

    function editAnnouncementCommit()
    {
	    global $db;
	    $record = array(
		    'user' => $_REQUEST['user'],
		    'title' => $_REQUEST['title'],
		    'text' => $_REQUEST['text']);
	    $db->AutoExecute('Obsedb_announcements',$record,'UPDATE',"`id` = '$_REQUEST[id]'");
	    SPMessage($this->phrase['editAnnouncementCommit'],"index2.php");
    }
    
    

    function addAnnouncementCommit()
    {
	    global $db;
	    $record = array(
		    'user' => $_REQUEST['user'],
		    'date' => date("m.d.Y"),
		    'title' => $_REQUEST['title'],
		    'text' => $_REQUEST['text']);

	    $db->AutoExecute('Obsedb_announcements',$record,'INSERT');
	    SPMessage($this->phrase['addAnnouncementCommit'],'index2.php');
    }
    
    

    function deleteAnnouncementCommit()
    {
	    global $db;
	    $db->Execute("DELETE FROM `Obsedb_announcements` WHERE `id` = '$_REQUEST[id]'");
	    SPMessage($this->phrase['deleteAnnouncementCommit'],'index2.php');
    }
}

?>