<div class="alt1">
  <div class="alt1_top">
    <img src="images/corners/alt1_tlc.gif" class="corner" width="10" height="10" style="display: none;">
    </div>
  

    <table border="0" cellspacing="0" cellpadding="10" width="100%">
      <tr>
        <td colspan="6">

          <b>
            <?php echo stripslashes($review->fields['title']); ?>
          </b>

        </td>
      </tr>

      <tr>

        <td>

          <b>Score</b>

        </td>

        <td>
          Modplay: <b>
            <?php echo $review->fields['Modplay']; ?>
          </b>
        </td>

        <td>
          Graphics: <b>
            <?php echo $review->fields['graphics']; ?>
          </b>
        </td>

        <td>
          Sound: <b>
            <?php echo $review->fields['sound']; ?>
          </b>
        </td>

        <td>
          Value: <b>
            <?php echo $review->fields['value']; ?>
          </b>
        </td>

        <td>
          Tilt: <b>
            <?php echo $review->fields['tilt']; ?>
          </b>
        </td>

      </tr>

      <?php if ($review->fields['Modid'] != '0') { ?>
      <tr>
        <td colspan="6" align="center">

          <b>
            <a href="Moddetails.php?id=<?php echo $review->fields['Modid']; ?>">View Mod Profile</a>
          </b>

        </td>
      </tr>
      <?php } ?>

    </table>

  
  <div class="alt1_bottom">
    <img src="images/corners/alt1_blc.gif" class="corner" width="10" height="10" style="display: none;">
    </div>
</div>
<br />
<div class="alt2">
  <div class="alt2_top">
    <img src="images/corners/alt2_tlc.gif" class="corner" width="10" height="10" style="display: none;">
    </div>
  <p><?php echo clean($review->fields['intro']); ?></p>
  <div class="alt2_bottom">
    <img src="images/corners/alt2_blc.gif" class="corner" width="10" height="10" style="display: none;">
    </div>
</div>


			<?php echo clean($review->fields['text']); ?>
