<?php


function do_review() {
global $start_table, $end_table, $alphanav, $review_title;
echo <<<EOF

   $start_table
   $review_title
   $end_table

EOF;
}
?>