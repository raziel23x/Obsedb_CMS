<?php
error_reporting(E_ALL ^ E_NOTICE);
include "global.php";

$cp->header();

$links = '<a href="menu_manager.php?do=add_link">Add Item</a> | '
		.'<a href="menu_manager.php">Manage Items</a>';
do_module_header('Menu Manager',$links,'configuration.php?setting=menu');

if (empty($_REQUEST['do']))
{

   do_form_header('menu_manager.php');
   do_table_header("Left Menu");

   $result = $db->Execute("SELECT * FROM `Obsedb_menu_items` WHERE `location` = 'left' ORDER BY `ordering`");
   while ($row = $result->FetchNextObject())
   {
      $bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");
      echo '<tr>'
      	. '<td bgcolor="'.$bgcolor.'"><input type="radio" name="id" value="'.$row->ID.'"> '.stripslashes($row->TITLE).'</td>'
      	. '<td bgcolor="'.$bgcolor.'">'.stripslashes($row->URL).'</td>'
      	. '</tr>';
	}

	if ($result->RecordCount() == 0)
	{
		echo '<tr><td colspan="2" class="formlabel">There are currently no menu items to display.</td></tr>';
	}

   echo '<tr>
         <td colspan="2" class="formlabel">
            <input type="submit" name="do" value="Edit Link">
            <input type="submit" name="do" value="Delete Link">
         </td>
        </tr>';
   do_table_footer();
   echo '</form>';

   do_form_header('menu_manager.php');
   do_table_header("Right Menu");
   $result = $db->Execute("SELECT * FROM `Obsedb_menu_items` WHERE `location` = 'right' ORDER BY `ordering`");
   while ($row = $result->FetchNextObject()) {
      $bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");
      echo '<tr>
            <td bgcolor="'.$bgcolor.'"><input type="radio" name="id" value="'.$row->ID.'"> '.$row->TITLE.'</td>
            <td bgcolor="'.$bgcolor.'">'.$row->URL.'</td>
           </tr>';

   }

	if ($result->RecordCount() == 0)
	{
		echo '<tr><td colspan="2" class="formlabel">There are currently no menu items to display.</td></tr>';
	}
   echo '<tr>
         <td colspan="2" class="formlabel">
            <input type="submit" name="do" value="Edit Link">
            <input type="submit" name="do" value="Delete Link">
         </td>
        </tr>';
   do_table_footer();
   echo '</form>';

   do_form_header('menu_manager.php');
   do_table_header("Top Menu");
   $result = $db->Execute("SELECT * FROM `Obsedb_menu_items` WHERE `location` = 'top' ORDER BY `ordering`");
   while ($row = $result->FetchNextObject()) {
      $bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");
      echo '<tr>
            <td bgcolor="'.$bgcolor.'"><input type="radio" name="id" value="'.$row->ID.'"> '.$row->TITLE.'</td>
            <td bgcolor="'.$bgcolor.'">'.$row->URL.'</td>
           </tr>';

   }
	if ($result->RecordCount() == 0)
	{
		echo '<tr><td colspan="2" class="formlabel">There are currently no menu items to display.</td></tr>';
	}
   echo '<tr>
         <td colspan="2" class="formlabel">
            <input type="submit" name="do" value="Edit Link">
            <input type="submit" name="do" value="Delete Link">
         </td>
        </tr>';
   do_table_footer();
   echo '</form>';

   do_form_header('menu_manager.php');
   do_table_header("Bottom Menu");
   $result = $db->Execute("SELECT * FROM `Obsedb_menu_items` WHERE `location` = 'bottom' ORDER BY `ordering`");
   while ($row = $result->FetchNextObject()) {
      $bgcolor = ($bgcolor == "#ECECFF" ? "#FFFFFF" : "#ECECFF");
      echo '<tr>
            <td bgcolor="'.$bgcolor.'"><input type="radio" name="id" value="'.$row->ID.'"> '.$row->TITLE.'</td>
            <td bgcolor="'.$bgcolor.'">'.$row->URL.'</td>
           </tr>';

   }
	if ($result->RecordCount() == 0)
	{
		echo '<tr><td colspan="2" class="formlabel">There are currently no menu items to display.</td></tr>';
	}
   echo '<tr>
         <td colspan="2" class="formlabel">
            <input type="submit" name="do" value="Edit Link">
            <input type="submit" name="do" value="Delete Link">
         </td>
        </tr>';
   do_table_footer();
   echo '</form>';
}

if ($_REQUEST['do'] == 'add_link') {

   do_form_header('menu_manager.php');
   do_table_header('Add Menu Item');
   echo '<tr>
         <td class="formlabel" valign="top">Select link type:</td>
         <td class="formlabel">
         <select name="type" size="10" style="width: 300px;">
            <option value="module">Link - Module</option>
            <option value="url">Link - Custom URL</option>
            <option value="page">Link - Generic Page</option>
            <option value="preview_section">Link - Preview Section</option>
            <option value="review_section">Link - Review Section</option>
            <option value="spacer">Spacer</option>

         </select>
         </td>
        </tr>';
   do_submit_row("Continue");
   do_table_footer();
   echo '<input type="hidden" name="do" value="add_link_step2">';
   echo '</form>';
   }

class Module
{
	function do_location_row()
	{
		echo '<tr>'
					.'<td class="formlabel" align="right"><b>Location</b></td>'
					.'<td class="formlabel"><select name="location">'
					.'<option value="left">Left Menu</option>'
					.'<option value="right">Right Menu</option>'
					.'<option value="top">Top Menu</option>'
					.'<option value="bottom">Bottom Menu</option>'
					.'</select></td></tr>';
	}
}

$module = new Module;

if ($_REQUEST['do'] == 'add_link_step2') {

   if ($_REQUEST['type'] == 'url') {

      do_form_header('menu_manager.php');
      do_table_header('Add Menu Item');
      do_text_row('Link Title','title');
      do_text_row('URL','url');
      do_text_row('Order','ordering','1');
		$module->do_location_row();
      echo '<tr><td class="formlabel"><b>Active</b></td>
            <td class="formlabel">
               <select name="active">
               <option value="1">Yes</option>
               <option value="0">No</option>
               </select>
            </td>
           </tr>';
      echo '<tr><td class="formlabel"><b>Open link in a new window</b></td>
              <td class="formlabel">
               <input type="checkbox" name="target" value="_blank">
           </td></tr>';
      do_submit_row('Continue');
      do_table_footer();
      echo '<input type="hidden" name="do" value="add_link_confirm">';
      echo '</form>';
   }
   if ($_REQUEST['type'] == 'page') {

      do_form_header('menu_manager.php');
      do_table_header('Add Menu Item');
      $result = $db->Execute("SELECT id,title FROM `Obsedb_pages` ORDER BY `title`");
      while ($row = $result->FetchNextObject()) {

         $options .= "<option value=\"pages.php?id=$row->ID\">" . stripslashes($row->TITLE) . "</option>\n";

      }
      do_text_row('Link Title','title');
      echo '<tr><td class="formlabel" valign="top">Select a page:</td>
                <td class="formlabel">
                  <select name="url" size="10" style="width: 300px;">
                  '.$options.'
                  </select>
                </td>
            </tr>';
      do_text_row('Order','ordering','1');
      $module->do_location_row();
      echo '<tr><td class="formlabel"><b>Active</b></td>
            <td class="formlabel">
               <select name="active">
               <option value="1">Yes</option>
               <option value="0">No</option>
               </select>
            </td>
           </tr>';
      echo '<tr><td class="formlabel"><b>Open link in a new window</b></td>
              <td class="formlabel">
               <input type="checkbox" name="target" value="_blank">
           </td></tr>';
      do_submit_row('Continue');
      do_table_footer();
      echo '<input type="hidden" name="do" value="add_link_confirm">';
      echo '</form>';
   }
   if ($_REQUEST['type'] == 'review_section') {

      do_form_header('menu_manager.php');
      do_table_header('Add Menu Item');
      $result = $db->Execute("SELECT id,title FROM `Obsedb_reviews_sections` ORDER BY `title`");
      while ($row = $result->FetchNextObject()) {

         $options .= "<option value=\"reviews.php?section=$row->ID\">" . stripslashes($row->TITLE) . "</option>\n";

      }
      do_text_row('Link Title','title');
      echo '<tr><td class="formlabel" valign="top">Review Sections:</td>
                <td class="formlabel">
                  <select name="url" size="10" style="width: 300px;">
                  '.$options.'
                  </select>
                </td>
            </tr>';
      do_text_row('Order','ordering','1');
      $module->do_location_row();
      echo '<tr><td class="formlabel" align="right"><b>Active</b></td>
            <td class="formlabel">
               <select name="active">
               <option value="1">Yes</option>
               <option value="0">No</option>
               </select>
            </td>
           </tr>';
      echo '<tr><td class="formlabel" align="right"><b>Open link in a new window</b></td>
              <td class="formlabel">
               <input type="checkbox" name="target" value="_blank">
           </td></tr>';
      do_submit_row('Continue');
      do_table_footer();
      echo '<input type="hidden" name="do" value="add_link_confirm">';
      echo '</form>';
   }
   if ($_REQUEST['type'] == 'preview_section') {

      do_form_header('menu_manager.php');
      do_table_header('Add Menu Item');
      $result = $db->Execute("SELECT id,title FROM `Obsedb_previews_sections` ORDER BY `title`");
      while ($row = $result->FetchNextObject()) {

         $options .= "<option value=\"previews.php?section=$row->ID\">" . stripslashes($row->TITLE) . "</option>\n";

      }
      do_text_row('Link Title','title');
      echo '<tr><td class="formlabel" valign="top" align="right"><b>Preview Sections</b></td>
                <td class="formlabel">
                  <select name="url" style="width: 300px;">
                  '.$options.'
                  </select>
                </td>
            </tr>';
      do_text_row('Order','ordering','1');
      $module->do_location_row();
      echo '<tr><td class="formlabel" align="right"><b>Active</b></td>
            <td class="formlabel">
               <select name="active">
               <option value="1">Yes</option>
               <option value="0">No</option>
               </select>
            </td>
           </tr>';
      echo '<tr><td class="formlabel" align="right"><b>Open link in a new window</b></td>
              <td class="formlabel">
               <input type="checkbox" name="target" value="_blank">
           </td></tr>';
      do_submit_row('Continue');
      do_table_footer();
      echo '<input type="hidden" name="do" value="add_link_confirm">';
      echo '</form>';
   }
   if ($_REQUEST['type'] == 'news_section') {

      do_form_header('menu_manager.php');
      do_table_header('Add Menu Item');
      $result = $db->Execute("SELECT id,title FROM `Obsedb_newss_sections` ORDER BY `title`");
      while ($row = $result->FetchNextObject()) {

         $options .= "<option value=\"news.php?section=$row->ID\">" . stripslashes($row->TITLE) . "</option>\n";

      }
      do_text_row('Link Title','title');
      echo '<tr><td class="formlabel" valign="top" align="right">News Sections:</td>
                <td class="formlabel">
                  <select name="url" size="10" style="width: 300px;">
                  '.$options.'
                  </select>
                </td>
            </tr>';
      do_text_row('Order','ordering','1');
      $module->do_location_row();
      echo '<tr><td class="formlabel" align="right"><b>Active</b></td>
            <td class="formlabel">
               <select name="active">
               <option value="1">Yes</option>
               <option value="0">No</option>
               </select>
            </td>
           </tr>';
      echo '<tr><td class="formlabel" align="right"><b>Open link in a new window</b></td>
              <td class="formlabel">
               <input type="checkbox" name="target" value="_blank">
           </td></tr>';
      do_submit_row('Continue');
      do_table_footer();
      echo '<input type="hidden" name="do" value="add_link_confirm">';
      echo '</form>';
   }
   if ($_REQUEST['type'] == 'link_section') {

      do_form_header('menu_manager.php');
      do_table_header('Add Menu Item');
      $result = $db->Execute("SELECT id,title FROM `Obsedb_links_sections` ORDER BY `title`");
      while ($row = $result->FetchNextObject()) {

         $options .= "<option value=\"links.php?section=$row->ID\">" . stripslashes($row->TITLE) . "</option>\n";

      }
      do_text_row('Link Title','title');
      echo '<tr><td class="formlabel" valign="top" align="right">Web Link Sections:</td>
                <td class="formlabel">
                  <select name="url" size="10" style="width: 300px;">
                  '.$options.'
                  </select>
                </td>
            </tr>';
      do_text_row('Order','ordering','1');
      $module->do_location_row();
      echo '<tr><td class="formlabel" align="right"><b>Active</b></td>
            <td class="formlabel">
               <select name="active">
               <option value="1">Yes</option>
               <option value="0">No</option>
               </select>
            </td>
           </tr>';
      echo '<tr><td class="formlabel" align="right"><b>Open link in a new window</b></td>
              <td class="formlabel">
               <input type="checkbox" name="target" value="_blank">
           </td></tr>';
      do_submit_row('Continue');
      do_table_footer();
      echo '<input type="hidden" name="do" value="add_link_confirm">';
      echo '</form>';
   }
   if ($_REQUEST['type'] == 'module') {

      do_form_header('menu_manager.php');
      do_table_header('Add Menu Item');
      $result = $db->Execute("SELECT id,title FROM `Obsedb_pages` ORDER BY `title`");
      while ($row = $result->FetchNextObject()) {

         $options .= "<option value=\"pages.php?id=$row->ID\">" . stripslashes($row->TITLE) . "</option>\n";

      }
      do_text_row('Link Title','title');
      echo '<tr><td class="formlabel" valign="top" align="right"><b>Modules</b></td>
                <td class="formlabel">
                  <select name="url" size="10" style="width: 300px;">
                  <option value="companies.php">Companies</option>
                  <option value="mailbag.php">Mailbag</option>
                  <option value="index.php">Main Page (index)</option>
                  <option value="search.php">Search</option>
                  <option value="Mods.php">Mods List</option>
                  <option value="previews.php">Previews</option>
                  <option value="reviews.php">Reviews</option>
				  <option value="rss_Mods.php">RSS Feed - Latest Mods</option>
				  <option value="rss_news.php">RSS Feed - Latest News</option>
                  </select>
                </td>
            </tr>';
      do_text_row('Order','ordering','1');
      $module->do_location_row();
      echo '<tr><td class="formlabel" align="right"><b>Active</b></td>
            <td class="formlabel">
               <select name="active">
               <option value="1">Yes</option>
               <option value="0">No</option>
               </select>
            </td>
           </tr>';
      echo '<tr><td class="formlabel" align="right"><b>Open link in a new window</b></td>
              <td class="formlabel">
               <input type="checkbox" name="target" value="_blank">
           </td></tr>';
      do_submit_row('Continue');
      do_table_footer();
      echo '<input type="hidden" name="do" value="add_link_confirm">';
      echo '</form>';
   }
}

if ($_REQUEST['do'] == 'Edit Link') {
   $menuitem = $db->Execute("SELECT * FROM `Obsedb_menu_items` WHERE `id` = '$_REQUEST[id]'");
   do_form_header('menu_manager.php');
   do_table_header('Edit Menu Item');
   do_text_row('Link Title','title',stripslashes($menuitem->fields['title']));
   do_text_row('URL','url',stripslashes($menuitem->fields['url']));
   do_text_row('Order','ordering',stripslashes($menuitem->fields['ordering']));
   echo '<tr><td class="formlabel"><b>Location</b></td>
         <td class="formlabel">
            <select name="location">';

      $locations = array(
         'left' => 'Left Menu',
         'right' => 'Right Menu',
         'top' => 'Top Menu',
         'bottom' => 'Bottom Menu'
         );
      foreach ($locations AS $key => $value) {

         if ($menuitem->fields['location'] == $key) {

            echo "<option value=\"$key\" selected>$value</option>";

         } else {

            echo "<option value=\"$key\">$value</option>";

         }
      }

   echo '
            </select>
         </td>
        </tr>';
   echo '<tr><td class="formlabel" align="right"><b>Active</b></td>
         <td class="formlabel">
            <select name="active">';
      if ($menuitem->fields['active'] == '1') {
         echo '
            <option value="1" selected>Yes</option>
            <option value="0">No</option>';
      } else {
         echo '
            <option value="1">Yes</option>
            <option value="0" selected>No</option>';
      }

   echo '
            </select>
         </td>
        </tr>';
   echo '<tr><td class="formlabel"><b>Open link in a new window</b></td>
           <td class="formlabel">';
   if ($menuitem->fields['target'] == '_blank') {
      echo '<input type="checkbox" name="target" value="_blank" checked>';
   } else {
      echo '<input type="checkbox" name="target" value="_blank">';
   }

   echo '</td></tr>';
   do_submit_row('Continue');
   do_table_footer();
   echo '<input type="hidden" name="id" value="'.$menuitem->fields['id'].'">';
   echo '<input type="hidden" name="do" value="edit_link_confirm">';
   echo '</form>';
   }

if ($_REQUEST['do'] == 'add_link_confirm') {

   $rs = $db->Execute("SELECT * FROM `Obsedb_menu_items` WHERE `id` = '-1'");
   $record = array(
      'title' => $_REQUEST['title'],
      'url' => $_REQUEST['url'],
      'target' => $_REQUEST['target'],
      'location' => $_REQUEST['location'],
      'ordering' => $_REQUEST['ordering'],
      'active' => $_REQUEST['active']
      );

   $sql = $db->GetInsertSQL($rs, $record);
   $db->Execute($sql);
   echo '<center>Link has been successfully added, <a href="menu_manager.php">click here to continue</a>.</center>';
   }

if ($_REQUEST['do'] == 'edit_link_confirm') {

   $rs = $db->Execute("SELECT * FROM `Obsedb_menu_items` WHERE `id` = '$_REQUEST[id]'");
   $record = array(
      'title' => $_REQUEST['title'],
      'url' => $_REQUEST['url'],
      'target' => $_REQUEST['target'],
      'location' => $_REQUEST['location'],
      'ordering' => $_REQUEST['ordering'],
      'active' => $_REQUEST['active']
      );

   $sql = $db->GetUpdateSQL($rs, $record);
   $db->Execute($sql);
   echo '<center>Link has been successfully updated, <a href="menu_manager.php">click here to continue</a>.</center>';
   }

if ($_REQUEST['do'] == 'Delete Link') {

   $db->Execute("DELETE FROM `Obsedb_menu_items` WHERE `id` = '$_REQUEST[id]'");
   echo '<center>Link has been successfully removed, <a href="menu_manager.php">click here to continue</a>.</center>';

   }

$cp->footer();
?>