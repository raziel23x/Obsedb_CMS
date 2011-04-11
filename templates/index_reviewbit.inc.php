<table border="0" cellspacing="0" cellpadding="5" width="100%">
      <tr>
         <td width="100%"><b>Latest Reviews</b></td>
      </tr>


<?php
global $spconfig;
$limit = $spconfig['frontpage_reviews_limit'];

$bgcolor = '';
$ReviewSections = FetchSections('Obsedb_reviews_sections');
$ReviewQuery = $db->Execute("SELECT id,title,section FROM `Obsedb_reviews` ORDER BY `id` DESC LIMIT 0,$limit");
while ($ReviewRow = $ReviewQuery->FetchNextObject()) {
   $bgcolor = ($bgcolor == "#FFFFFF" ? "#E9E9E9" : "#FFFFFF");
?>

<tr>
   <td bgcolor="<?php echo $bgcolor; ?>" colspan="3" style="padding: 3px;">
      <font style="font-size: 11px;">
      <?php echo $ReviewSections["$ReviewRow->SECTION"]; ?>: <a href="reviews.php?do=view&id=<?php echo $ReviewRow->ID; ?>"><?php echo stripslashes($ReviewRow->TITLE); ?></a>
      </font>
   </td>
</tr>

<?php
   }
$bgcolor = '';
?>

   <tr>
      <td colspan="3" style="padding: 3px;">
      <a href="reviews.php?">Browse Reviews</a>
      </td>
   </tr>
</table>