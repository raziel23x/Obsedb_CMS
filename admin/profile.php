<?php

switch($_REQUEST['do'])
{
	case 'save_profile':
		$refresh = "profile.php";
		break;
}

include "global.php";
$cp->header();
echo '<font style="font-size: 12pt; font-weight: bold;">Manage Your Profile</font>';

echo '<p>';

if (!isset($_REQUEST['do'])) {

	$result = $db->Execute("SELECT * FROM `Obsedb_members` WHERE `ID` = '" . $_SESSION['pwzid'] . "'");
	do_form_header('profile.php');
	do_table_header('Personal Details');
	do_text_row('Username','username',stripslashes($result->fields['PSEUDO']));
	do_text_row('E-mail Address','email',stripslashes($result->fields['EMAIL']));
	echo '<tr>
			<td class="formlabel" align="right"><b>Current Password</b></td>
			<td class="formlabel"><input type="password" name="curpass"></td>
		  </tr>';
	echo '<tr>
			<td class="formlabel" align="right"><b>New Password</b></td>
			<td class="formlabel"><input type="password" name="newpass" size="60"></td>
		  </tr>';
	echo '<tr>
			<td class="formlabel" align="right"><b>Confirm New Password</b></td>
			<td class="formlabel"><input type="password" name="newpass_confirm" size="60"></td>
		  </tr>';
	do_submit_row('Update Profile');
	do_table_footer();
	echo '<input type="hidden" name="do" value="save_profile">';
	echo '</form>';

}

if ($_REQUEST['do'] == 'save_profile') {

	$rs = $db->Execute("SELECT * FROM `Obsedb_members` WHERE `ID` = '" . $_SESSION['pwzid'] . "'");
	$record = array(
		'PSEUDO' => $_REQUEST['username'],
		'EMAIL' => $_REQUEST['email']
		);


	if (isset($_REQUEST['curpass'])) {
		if (md5($_REQUEST['curpass']) == $rs->fields['PASS']) {
			$sql = $db->GetUpdateSQL($rs, $record);
			$db->Execute($sql);
			if ( (!empty($_REQUEST['newpass'])) && ($_REQUEST['newpass'] == $_REQUEST['newpass_confirm']) ) {
				$db->Execute("UPDATE `Obsedb_members` SET `PASS` = '" . md5($_REQUEST[newpass]) . "' WHERE `id` = '" . $_SESSION['pwzid'] . "'");
			}
		} else {
			echo 'ERROR: Please enter your current password again.';
			exit;
		}
	}

	SPMessage('Success | Your profile has been updated.','profile.php');

}

echo '</p>';

$cp->footer();

?>