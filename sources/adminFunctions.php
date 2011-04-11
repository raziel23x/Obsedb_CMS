<?php



function do_table_header( $title='' )
{
	// ==============================
	// Table Header
	// ==============================

	echo '
	    <div style="padding: 10px;">
		<table border="0" cellspacing="0" cellpadding="4" width="100%" style="border: 1px solid #d7d7d7;border-bottom: 0px;">
			<tr>
				<td class="bar">', $title, '</td>
			</tr>
		</table>
		<table border="0" cellspacing="0" cellpadding="4" width="100%" style="border: 1px solid #d7d7d7; border-top: 0px;">';
}



function do_table_footer()
{
	// ==============================
	// Table Footer
	// ==============================

	echo '
		</table></div>';
}



function do_module_header($title,$links='',$helpfile='',$settings='',$search='')
{
	// ==============================
	// Module header link tool for the lazy
	// ==============================

	if ($settings)
	{
		$settingslink = "<a href=\"$settings\">Module Settings</a> &nbsp; ";
	}
	if ($search)
	{
		$searchlink = "<a href=\"$search\">Search</a> &nbsp; ";
	}

		# This function generates the header area for a form
		print "<table border=\"0\" cellspacing=\"0\" cellpadding=\"13\" width=\"100%\">\n";
		print "<tr>\n";
		print "<td style=\"background-color: #ffffff;\">\n";
		print "<div style=\"font-size: 12pt; color: #448cca;\">$title</div>";
		print "<div style=\"font-size: 8pt; color: #000000;\"><br />$links</div>";
		print "</td>\n";
		print "</tr>\n";
		print "</table>\n";

}



function do_text_row($title, $name, $value='')
{
	// ==============================
	// Text Field
	// ==============================
	
	$value = str_replace( '"', '&quot;', $value );

	echo '
		<tr>
			<td class="formlabel" style="text-align: right; font-weight: bold;">
				', $title, '
			</td>
			<td class="formlabel">
				<input type="text" name="', $name, '" value="', $value, '" size="50">
			</td>
		</tr>';
}


function do_blank_row( $text )
{
    echo "<tr>\n"
        ."<td class=\"formlabel\" colspan=\"2\">$text</td>\n"
        ."</tr>\n";
}


function do_select_row($title, $name, $options, $selid='null')
{
	// ==============================
	// Select Field
	// ==============================

	if ($selid != 'null')
	{
		$htmlop = '';
		foreach($options AS $key => $value)
		{
			if ($key == $selid)
			{
				$htmlop .= "<OPTION VALUE=\"$key\" selected>$value</OPTION>\n";
			} else {
				$htmlop .= "<OPTION VALUE=\"$key\">$value</OPTION>\n";
			}
		}
	} else {
		$htmlop = '';
		foreach($options AS $key => $value)
		{
			$htmlop .= "<OPTION VALUE=\"$key\">$value</OPTION>\n";
		}
	}

echo <<<EOF

	<TR>
		<TD VALIGN="top" CLASS="formlabel" ALIGN="right">
		<B>$title</B>
		</TD>
		<TD CLASS="formlabel">
		<SELECT NAME="$name">
		$htmlop
		</SELECT>
		</TD>
	</TR>

EOF;
}


function do_form_header($action)
{
	// ==============================
	// Form Headers
	// ==============================

echo <<<EOF

	<form method="post" action="$action" name="SPform" onsubmit="return submitForm();">

EOF;
}



function do_form_footer()
{
	// ==============================
	// Form Footers
	// ==============================

echo <<<EOF

	</form>

EOF;
}

function do_hidden_row( $name, $value='' )
{
    print "<input type=\"hidden\" name=\"$name\" value=\"$value\">\n";
}



function SPMessage($text,$link='')
{
	// ==============================
	// Confirmation Message
	// ==============================

	do_table_header('Obsedb CMS Message');
	echo '
		<tr>
			<td class="formlabel" style="line-height: 200%; font-size: 12px;">

				<img src="../images/admin/info.jpg" align="left" hspace="15">
				<span style="font-weight: bold;">'.$text.'</span>

			</td>
		</tr>';
    
    if (!empty($link))
    {

	    echo "<TD class=\"formlabel\" ALIGN=\"center\" STYLE=\"font-size: 12px;\">"
		    ."<A HREF=\"$link\">(or click here if you do not wish to wait)</A>"
		    ."</TD>"
		    ."</TR>";
    }
	do_table_footer();
}



function do_textarea_row($title, $name, $value='')
{
	// ==============================
	// WYSIWYG Editor
	// ==============================

	$value = RTESafe( $value );

echo <<<EOF

	<TR>
		<TD CLASS="formlabel" COLSPAN="2">
		<B>$title</B><BR />
        <script language="JavaScript" type="text/javascript">
        function submitForm() {
           updateRTEs('$name');
           return true;
        }
        initRTE("../images/wysiwyg/", "", "");
        </script>
        <noscript><b>Javascript must be enabled to use this WYSIWYG editor.</b></noscript>

        <script language="JavaScript" type="text/javascript">
        writeRichText('$name', '$value', 400, 200, true, false);
        </script>
		</TD>
	</TR>

EOF;
}



function do_submit_row($title='Submit')
{
	// ==============================
	// Submit Button
	// ==============================

echo <<<EOF

	<TR>
		<TD COLSPAN="2" CLASS="formlabel">
		<INPUT TYPE="submit" NAME="submit" VALUE="$title">
		</TD>
	</TR>

EOF;
}



function RTESafe($strText='')
{
	// ==============================
	// Used by WYSIWYG Editor
	// ==============================

   //returns safe code for preloading in the RTE
   $tmpString = trim($strText);

   //convert all types of single quotes
   $tmpString = str_replace(chr(145), chr(39), $tmpString);
   $tmpString = str_replace(chr(146), chr(39), $tmpString);
   $tmpString = str_replace("'", "&#39;", $tmpString);

   //convert all types of double quotes
   $tmpString = str_replace(chr(147), chr(34), $tmpString);
   $tmpString = str_replace(chr(148), chr(34), $tmpString);
// $tmpString = str_replace("\"", "\"", $tmpString);

   //replace carriage returns & line feeds
   $tmpString = str_replace(chr(10), " ", $tmpString);
   $tmpString = str_replace(chr(13), " ", $tmpString);

   return $tmpString;
}



function clean($text='')
{
	// ==============================
	// Clean text of slashes and html
	// ==============================

	$text = stripslashes( $text );
	$text = htmlentities( $text );

	return $text;
}



function GenerateForm($target,$title,$do,$fieldarray,$hiddendata='',$upload='false')
{
	// ==============================
	// Generate a form from an array
	// ==============================
    
    if ($upload == 'false')
    {
        do_form_header( $target );
    } else {
        print '<form method="post" action="'.$target.'" enctype="multipart/form-data">';
    }
    
   
   do_table_header($title);

   foreach($fieldarray AS $key => $value) {

      switch($value["type"]) {
         case 'text':
            do_text_row($value["title"],$value["name"],$value["value"]);
            break;
         case 'submit':
            do_submit_row($value["title"]);
            break;
         case 'textarea':
         	do_table_footer();
         	do_table_header($value["title"]);
            do_textarea_row('',$value["name"],$value["value"]);
            break;
         case 'select':
		 	do_select_row($value["title"], $value["name"], $value["value"], $value["selected"]);
            break;
         case 'spacer':
         	do_table_footer();
         	do_table_header($value["title"]);
         	break;
         case 'file':
            print "<tr><td class=\"formlabel\" align=\"right\"><b>".$value["title"]."</b></td>";
            print "<td class=\"formlabel\"><input type=\"file\" name=\"".$value["name"]."\"></td></tr>";
            break;
         case 'blank':
            do_blank_row( $value["title"] );
            break;
         }
      }
   do_table_footer();
   echo '<input type="hidden" name="do" value="'.$do.'">';

   if (!empty($hiddendata)) {
      foreach ($hiddendata AS $key => $value) {
         echo "<input type=\"hidden\" name=\"$key\" value=\"$value\">";
         }
      }
   }



function FetchSections($table)
{
	// ==============================
	// Fetch section ID and TITLE into array
	// ==============================

   global $db;
   $result = $db->Execute("
   	SELECT
		s.id, s.title
	FROM
		$table AS s
	ORDER BY
		s.title");
   $data = array('0' => 'None');
   while ($row = $result->FetchNextObject()) {
      $data["$row->ID"] = stripslashes($row->TITLE);
   }
   return $data;
}



function ListModules()
{
	// ==============================
	// Fetch module list into variable
	// ==============================

   global $db;
   $result = $db->Execute("SELECT * FROM `Obsedb_modules` WHERE `active` = '1' ORDER BY `title`");
   while ($row = $result->FetchNextObject())
   {
      $modules .= "<tr><td class=\"menu\"><a href=\"" . stripslashes($row->URL) . "\">" . stripslashes($row->TITLE) . "</a></td></tr>";
   }
   return $modules;
}


?>