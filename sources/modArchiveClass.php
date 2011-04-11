<?php

class Module 
{
    function main()
    {
        global $db;

        if (isset($_REQUEST['section']))
        {
	        $where = "WHERE Obsedb_news.section = $_REQUEST[section]";
        }

        // Globalize Variables
        $search 	= $_REQUEST['search'];
        $keyword 	= $_REQUEST['keyword'];
        $month 		= $_REQUEST['month'];
        $year 		= $_REQUEST['year'];

        do_header();

        echo '<form method="post" action="archive.php">';
        echo '<table border="0" cellspacing="0" cellpadding="0" width="100%">';
        echo '<tr>';
        echo '<td width="25%">Keywords:</td>';
        echo '<td width="25%">Month:</td>';
        echo '<td width="25%">Year:</td>';
        echo '<td width="25%"></td>';
        echo '</tr>';
        echo '<tr>';

        echo '<td width="25%"><input type="text" name="keyword" size="15"></td>';

        echo '<td width="25%"><select name="month">';
        echo '<option value="' . date("m") . '">' . date("F") . '</option>';
        echo '<option value="01">January</option>';
        echo '<option value="02">February</option>';
        echo '<option value="03">March</option>';
        echo '<option value="04">April</option>';
        echo '<option value="05">May</option>';
        echo '<option value="06">June</option>';
        echo '<option value="07">July</option>';
        echo '<option value="08">August</option>';
        echo '<option value="09">September</option>';
        echo '<option value="10">October</option>';
        echo '<option value="11">November</option>';
        echo '<option value="12">December</option>';
        echo '</select></td>';

        echo '<td width="25%"><select name="year">';
        $thisyear = date("Y");
        $startyear = $thisyear;
        while ($startyear >= $thisyear - 5) {
	        if ($startyear == $thisyear)
	        {
		        echo "<option value=\"$startyear\" selected>$startyear</option>";
	        } else {
		        echo "<option value=\"$startyear\">$startyear</option>";
	        }
	        $startyear--;
        }
        echo '</select></td>';


        echo '<td width="25%"><input type="submit" value="List Articles" name="submit"></td>';

        echo '</tr>';
        echo '</table>';
        echo '<input type="hidden" name="search" value="1">';
        echo '</form>';

        echo '<table border="0" cellspacing="0" cellpadding="4" width="100%">';

        $sections = FetchSections("Obsedb_news_sections");

        $specialdata = "<b>News Sections</b><br />";
        foreach ($sections AS $key => $value)
        {
	        $specialdata .= "&nbsp;";
	        $specialdata .= '<a href="archive.php?section='.$key.'">'.stripslashes($value).'</a><br />';
        }
        $specialdata .= "<br />";

        // Decide which query to use
        if ($search == 1) {
	        if (!empty($keyword)) {
		        $where = " AND `title` LIKE '%$keyword%'";
	        }
	        $result = $db->Execute("SELECT id,title,author,date,section FROM Obsedb_news WHERE date LIKE '".$year.".".$month.".%' $where ORDER BY date DESC");
	        } else {
	        $result = $db->Execute("SELECT id,title,author,date,section FROM Obsedb_news ORDER BY date DESC LIMIT 0,50");
	        }


        while ($row = $result->FetchNextObject())
        {
	        echo '<tr>';
	        echo '<td><a href="index.php?do=viewarticle&id='.$row->ID.'">' . $row->TITLE . '</a></td>';
	        echo '<td>' . $row->DATE . '</td>';
	        echo '<td>' . $row->AUTHOR . '</td>';
	        echo '</tr>';
        }

        echo '</table><br /><br />';

        do_footer();
    }
}

?>