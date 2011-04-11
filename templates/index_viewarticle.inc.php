<?php
global $db, $start_table, $end_table;
$result = $db->Execute("SELECT * FROM `Obsedb_news` WHERE `id` = '$_REQUEST[id]'");
// Variables for view article page
$id = $result->fields['id'];
$title = stripslashes($result->fields['title']);
$intro = clean($result->fields['intro']);
$text = clean($result->fields['text']);
$word_count = word_count($result->fields['text']) + word_count($result->fields['intro']);
$date = stripslashes($result->fields['date']);

echo <<<EOF

<table border="0" cellspacing="0" cellpadding="0" width="100%">
   <tr>
      <td><font class="newstitle"><b>$title</b></font></td>
      <td align="right"><a href="index.php?do=printarticle&id=$id"><img src="images/print.png" border="0" alt="Print Article"></a></td>
   </tr>
</table>

	<p class="news_introtext">
	$intro
	</p>
	
	<p class="news_maintext">
	$text
	<br /><br />
	<b>Word Count:</b> $word_count <br />
	<b>Date Posted:</b> $date <br />
	</p>


EOF;
?>