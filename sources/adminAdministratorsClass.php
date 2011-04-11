<?php

class Module
{

    var $phrase;
    
    function initForm()
    {
        global $cp;
        
        $cp->header();
        
        $this->phrase = $cp->getPhrases( 'adminAdministrators' );
        
        if (defined('SUPERADMIN_MODE'))
        {
	        $this->header();

	        switch($_REQUEST['do'])
	        {
		        case 'add_user':
			        $this->add_user();
			        break;
		        case 'add_confirm':
			        $this->add_confirm();
			        break;
		        case $this->phrase['do_delete_user']:
			        $this->delete_user();
			        break;
		        case $this->phrase['do_edit_user']:
			        $this->edit_user();
			        break;
		        case 'edit_confirm':
			        $this->edit_confirm();
			        break;
		        case $this->phrase['do_reset_password']:
			        $this->reset_password();
			        break;
		        case 'reset_confirm':
			        $this->reset_confirm();
			        break;
		        default:
			        $this->manage_users();
			        break;
	        }

        } else {

	        echo "You do not have super administrator permissions.";

        }
        
        $cp->footer();
        
    }
        

	function header()
	{
	    global $lang, $cp;
	    
		$links = 	'<a href="administrators.php?do=add_user">'.$this->phrase['add_user'].'</a> | '
				   .'<a href="administrators.php">'.$this->phrase['manage_users'].'</a>';
		do_module_header($this->phrase['administrators'],$links);
	}

	function delete_user()
	{
		global $db;
		$db->Execute("DELETE FROM `Obsedb_members` WHERE `ID` = '$_REQUEST[id]'");
		print $this->phrase['account_deleted'];
	}

	function add_confirm()
	{
		global $db, $cp;
		$phone      = $cp->getParam( 'phone' );
		$rs = $db->Execute("SELECT * FROM `Obsedb_members` WHERE `ID` = '-1'");
		$record = array(
			'PSEUDO' => $_REQUEST['pseudo'],
			'PASS' => md5($_REQUEST['password']),
			'EMAIL' => $_REQUEST['email'],
			'ACTIF' => '1',
			'NOM' => 'Administrateur',
			'fname' => $_REQUEST['fname'],
			'lname' => $_REQUEST['lname'],
			'phone' => $phone
			);
		$rssql = $db->GetInsertSQL($rs, $record);
		$db->Execute($rssql);
		SPMessage( $this->phrase['addAdministratorCommit'] );
	}

	function reset_confirm()
	{
		global $db;
		$rs = $db->Execute("SELECT * FROM `Obsedb_members` WHERE `ID` = '$_REQUEST[id]'");
		$record = array(
			'PASS' => md5($_REQUEST['password']),
			);
		$rssql = $db->GetUpdateSQL($rs, $record);
		$db->Execute($rssql);
		SPMessage($this->phrase['resetPasswordCommit']);
	}

	function edit_confirm()
	{
		global $db, $cp;
		$phone      = $cp->getParam( 'phone' );
		$rs = $db->Execute("SELECT * FROM `Obsedb_members` WHERE `ID` = '$_REQUEST[id]'");
		$record = array(
			'PSEUDO' => $_REQUEST['pseudo'],
			'EMAIL' => $_REQUEST['email'],
			'fname' => $_REQUEST['fname'],
			'lname' => $_REQUEST['lname'],
			'phone' => $phone
			);
		$rssql = $db->GetUpdateSQL($rs, $record);
		$db->Execute($rssql);
		SPMessage($this->phrase['editAccountCommit']);
	}

	function add_user()
	{
		global $db;
		do_form_header('administrators.php');
		do_table_header($this->phrase['add_admin']);
		do_text_row($this->phrase['username'],'pseudo');
		do_text_row($this->phrase['email_address'],'email');
		do_text_row($this->phrase['first_name'],"fname");
		do_text_row($this->phrase['last_name'],"lname");
		do_text_row($this->phrase['password'],'password');
		do_table_footer();
		do_table_header( 'Contact Info' );
		do_text_row('Phone Number', 'phone');
		do_submit_row($this->phrase['confirm']);
		do_table_footer();
		echo "<input type=\"hidden\" name=\"do\" value=\"add_confirm\">";
		echo "</form>";
	}

	function edit_user()
	{
		global $db, $cp;
		$id = $cp->getParam('id');
		$result = $db->Execute("SELECT * FROM `Obsedb_members` WHERE `id` = '$id'");
		do_form_header('administrators.php');
		do_table_header($this->phrase['edit_admin']);
		do_text_row($this->phrase['username'], 'pseudo', stripslashes($result->fields['PSEUDO']));
		do_text_row($this->phrase['email_address'], 'email', stripslashes($result->fields['EMAIL']));
		do_text_row($this->phrase['first_name'],"fname",stripslashes($result->fields['fname']));
		do_text_row($this->phrase['last_name'],"lname",stripslashes($result->fields['lname']));
		do_table_footer();
		do_table_header( 'Contact Info' );
		do_text_row('Phone Number', 'phone', stripslashes($result->fields['phone']));
		do_submit_row($this->phrase['confirm']);
		do_table_footer();
		echo '<input type="hidden" name="do" value="edit_confirm">';
		echo '<input type="hidden" name="id" value="'.$id.'">';
		echo '</form>';
	}

	function reset_password()
	{
		global $db, $cp;
		$id = $cp->getParam('id');
		do_form_header('administrators.php');
		do_table_header($this->phrase['change_password']);
		do_text_row($this->phrase['new_password'],"password");
		do_submit_row($this->phrase['save_changes']);
		do_table_footer();
		echo '<input type="hidden" name="do" value="reset_confirm">';
		echo '<input type="hidden" name="id" value="'.$id.'">';
		echo '</form>';
	}

	function manage_users()
	{
		global $db;
		do_form_header('administrators.php');
		do_table_header($this->phrase['manage_users']);
		$result = $db->Execute("SELECT * FROM `Obsedb_members` ORDER BY `PSEUDO`");
		while ($row = $result->FetchNextObject()) {
			echo "<tr><td class=\"formlabel\"><input type=\"checkbox\" name=\"id\" value=\"$row->ID\"></td>"
				 . "<td class=\"formlabel\" width=\"100%\"><b>$row->PSEUDO</b></td></tr>";
			}
		echo "<tr><td colspan=\"2\" class=\"formlabel\">"
			 . "<input type=\"submit\" name=\"do\" value=\"" . $this->phrase['do_edit_user'] . "\"> "
			 . "<input type=\"submit\" name=\"do\" value=\"" . $this->phrase['do_delete_user'] . "\"> "
			 . "<input type=\"submit\" name=\"do\" value=\"" . $this->phrase['do_reset_password'] . "\"> "
			 . "</td></tr>";
		do_table_footer();
		echo "</form>";
	}
}

?>