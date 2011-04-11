<?php

function do_alpha_link($key) {
return <<<EOF

	<a href="previews.php?browse=$key">$key</a>

EOF;
}

function do_alpha_nav() {
global $start_table, $end_table, $alphanav;
echo <<<EOF

	$start_table
	<center>
	$alphanav
	</center>
	$end_table

EOF;
}

function do_preview_results() {
global $start_table, $end_table, $preview_rows;
echo <<<EOF
   <br />
   $start_table
   <table border="0" cellspacing="5" cellpadding="0" width="100%">
      <tr>
         <td width="75%" style="font-size: 10px;"><b>Title</b></td>
         <td width="25%" style="font-size: 10px;"><b>Section</b></td>
      </tr>
   $preview_rows
   <tr><td colspan="2" height="1" bgcolor="#C0C0C0" style="height:1px;"></td></tr>
   </table>
   $end_table

EOF;
}

function do_preview_row($id,$title,$section) {
return <<<EOF
   <tr><td colspan="2" height="1" bgcolor="#C0C0C0" style="height:1px;"></td></tr>
   <tr>
      <td style="font-size: 10px;">&nbsp; <a href="previews.php?do=view&id=$id">$title</a></td>
      <td style="font-size: 10px;">$section</td>
   </tr>
EOF;
}

function do_preview() {
global $start_table, $end_table, $alphanav, $preview_title;
echo <<<EOF

   $start_table
   $preview_title
   $end_table

EOF;
}
?>