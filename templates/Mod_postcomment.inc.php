<form method="post" action="post_comment.php">
  <div class="alt1">
  <div class="alt1_top">
    <img src="images/corners/alt1_tlc.gif" class="corner" width="10" height="10" style="display: none;">
    </div>
      <p>
        <b>Comments</b>
        <br />
    <textarea rows="3" cols="50" name="comment"></textarea><br />
    <input type="submit" name="submit" value="Post Comment">
    <input type="hidden" name="contentid" value="<?php echo $_REQUEST[id]; ?>">
    <input type="hidden" name="m" value="Mods">
    </p>
  <div class="alt1_bottom">
    <img src="images/corners/alt1_blc.gif" class="corner" width="10" height="10" style="display: none;">
    </div>
</div>
</form>