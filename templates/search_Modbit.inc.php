
<table border="0" cellspacing="0" cellpadding="4" width="100%" style="border: 1px solid #C0C0C0;">
   <tr>
      <td style="background: #F1F1F1;" colspan="3">
         <a href="Moddetails.php?id=<?php echo $row->ID; ?>"><?php echo stripslashes($row->TITLE); ?></a>
      </td>
   </tr>
   <tr>
      <td style="background: #F1F1F1;">
         Platform: <b><?php echo stripslashes($sections["$row->SECTION"]); ?></b>
      |
         Publisher: <b><?php echo stripslashes($companies["$row->PUBLISHER"]); ?></b>
      |
         Developer: <b><?php echo stripslashes($companies["$row->DEVELOPER"]); ?></b>
      </td>
   </tr>
</table><br />