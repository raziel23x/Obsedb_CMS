<table border="0" cellspacing="0" cellpadding="5" width="100%">
      <tr>
         <td width="100%"><b>Latest Previews</b></td>
      </tr>


<?php
global $spconfig;
$limit = $spconfig['frontpage_previews_limit'];

$PreviewSections = FetchSections('Obsedb_previews_sections');
$PreviewQuery = $db->Execute("SELECT id,title,section FROM `Obsedb_previews` ORDER BY `id` DESC LIMIT 0,$limit");
while ($PreviewRow = $PreviewQuery->FetchNextObject()) {
   $bgcolor = ($bgcolor == "#FFFFFF" ? "#E9E9E9" : "#FFFFFF");
?>

<tr>
   <td bgcolor="<?php echo $bgcolor; ?>" colspan="3" style="padding: 3px;">
      <font style="font-size: 11px;">
      <?php echo $PreviewSections["$PreviewRow->SECTION"]; ?>: <a href="previews.php?do=view&id=<?php echo $PreviewRow->ID; ?>"><?php echo stripslashes($PreviewRow->TITLE); ?></a>
      </font>
   </td>
</tr>

<?php
   }
$bgcolor = '';
?>

   <tr>
      <td colspan="3" style="padding: 3px;">
      <a href="previews.php?">Browse Previews</a>
      </td>
   </tr>
</table>