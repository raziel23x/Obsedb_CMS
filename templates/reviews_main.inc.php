<?php
do_header();

// Special menu items (sections)
$specialdata = "<b>Review Sections</b><br />";
foreach ($sections AS $key => $value) {
   $specialdata .= "&nbsp;<a href=\"reviews.php?section=$key\">$value</a><br />";
}
$specialdata .= "<br />";

require_once("templates/reviews_alphanav.inc.php");

?>

<br />
<?php echo $start_table; ?>
   <table border="0" cellspacing="5" cellpadding="0" width="100%">
      <tr>
         <td width="75%" style="font-size: 10px;"><b>Title</b></td>
         <td width="25%" style="font-size: 10px;"><b>Section</b></td>
      </tr>
      <?php echo $review_rows; ?>
   <tr><td colspan="2" height="1" bgcolor="#C0C0C0" style="height:1px;"></td></tr>
   </table>
<?php echo $end_table; ?>