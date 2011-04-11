<?php

// ################################
// Clean data from wysiwyg encoding and remove all slashes
// ################################
function clean($text) {
   $text = html_entity_decode($text);
   $text = stripslashes($text);
   return $text;
   }

// ################################
// Count words in string
// ################################
function word_count($text) {
   $text = html_entity_decode($text);
   $text = stripslashes($text);
   $text = strip_tags($text);
   $text = count(preg_split('/\W+/', $text, -1, PREG_SPLIT_NO_EMPTY));
   return $text;
   }

// ################################
// Get section id&title for any type of content
// ################################
function FetchSections($table) {
   global $db;
   $result = $db->Execute("SELECT id,title FROM `$table` ORDER BY `id`");
   $data = array();
   while ($row = $result->FetchNextObject()) {
      $data["$row->ID"] = stripslashes($row->TITLE);
   }
   return $data;
   }

// ################################
// Cache company names
// ################################
function FetchCompanies() {
   global $db;
   $result = $db->Execute("SELECT id,title FROM `Obsedb_companies` ORDER BY `id`");
   $data = array();
   while ($row = $result->FetchNextObject()) {
      $data["$row->ID"] = stripslashes($row->TITLE);
   }
   return $data;
   }

// ################################
// Generate the related content for any piece of content
// ################################
function build_matrix($type, $id) {
   global $db, $start_table, $end_table;
   echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\"><tr>";
   $result = $db->Execute("
   SELECT
      Obsedb_matrix.ctype, Obsedb_matrix.cid, Obsedb_matrix.reltype, Obsedb_matrix.relid, Obsedb_screenshots.id, Obsedb_screenshots.thumb
   FROM
      Obsedb_matrix, Obsedb_screenshots
   WHERE
      Obsedb_matrix.ctype = '$type' AND
      Obsedb_matrix.cid = '$id' AND
      Obsedb_matrix.reltype = 'screenshots' AND
      Obsedb_screenshots.id = Obsedb_matrix.relid");
      $counter = 0;
   while ($row = $result->FetchNextObject()) {
      $counter++;
      if ($counter == '1') { echo "<tr>"; }
      echo "<td align=\"center\" width=\"33%\"><a href=\"screenshots.php?id=".$row->ID."\"><img src=\"$row->THUMB\" border=\"0\"></a><br /><br /></td>";
      if ($counter == '3') {
         echo "</tr>";
         $counter = 0;
         }
      }
   echo "</tr></table>";

   $result = $db->Execute("SELECT * FROM `Obsedb_matrix` WHERE `ctype` = '$type' AND `cid` = '$id' AND `reltype` = 'news'");
   if ($result->RecordCount() > 0) {
      echo "<ul><b>Related News</b>";
      while ($row = $result->FetchNextObject()) {
         $article = $db->Execute("SELECT id,title FROM `Obsedb_news` WHERE `id` = '$row->RELID'");
         echo "<li> <a href=\"index.php?do=viewarticle&id=".$article->fields['id']."\">", clean($article->fields['title']), "</a></li>";
         }
      }
   echo '</ul>';

   $result = $db->Execute("SELECT * FROM `Obsedb_matrix` WHERE `ctype` = '$type' AND `cid` = '$id' AND `reltype` = 'Mods'");
   if ($result->RecordCount() > 0) {
      echo "<ul><b>Related Mods</b>";
      while ($row = $result->FetchNextObject()) {
         $Mod = $db->Execute("SELECT id,title FROM `Obsedb_Mods` WHERE `id` = '$row->RELID'");
         echo "<li> <a href=\"Moddetails.php?id=".$Mod->fields['id']."\">", clean($Mod->fields['title']), "</a></li>";
         }
      }
   echo '</ul>';

   $result = $db->Execute("SELECT * FROM `Obsedb_matrix` WHERE `ctype` = '$type' AND `cid` = '$id' AND `reltype` = 'pages'");
   if ($result->RecordCount() > 0) {
      echo "<ul><b>Related Pages</b>";
      while ($row = $result->FetchNextObject()) {
         $page = $db->Execute("SELECT id,title FROM `Obsedb_pages` WHERE `id` = '$row->RELID'");
         echo "<li> <a href=\"pages.php?id=".$page->fields['id']."\">", clean($page->fields['title']), "</a></li>";
         }
      }
   echo '</ul>';

   $result = $db->Execute("SELECT * FROM `Obsedb_matrix` WHERE `ctype` = '$type' AND `cid` = '$id' AND `reltype` = 'reviews'");
   if ($result->RecordCount() > 0) {
      echo "<ul><b>Related Reviews</b>";
      while ($row = $result->FetchNextObject()) {
         $review = $db->Execute("SELECT id,title FROM `Obsedb_reviews` WHERE `id` = '$row->RELID'");
         echo "<li> <a href=\"reviews.php?do=view&id=".$review->fields['id']."\">", clean($review->fields['title']), "</a></li>";
         }
      }
   echo '</ul>';

   $result = $db->Execute("SELECT * FROM `Obsedb_matrix` WHERE `ctype` = '$type' AND `cid` = '$id' AND `reltype` = 'previews'");
   if ($result->RecordCount() > 0) {
      echo "<ul><b>Related Previews</b>";
      while ($row = $result->FetchNextObject()) {
         $preview = $db->Execute("SELECT id,title FROM `Obsedb_previews` WHERE `id` = '$row->RELID'");
         echo "<li> <a href=\"previews.php?do=view&id=".$preview->fields['id']."\">", clean($preview->fields['title']), "</a></li>";
         }
      }
   echo '</ul>';

   $result = $db->Execute("SELECT * FROM `Obsedb_matrix` WHERE `ctype` = '$type' AND `cid` = '$id' AND `reltype` = 'companies'");
   if ($result->RecordCount() > 0) {
      echo "<ul><b>Related companies</b>";
      while ($row = $result->FetchNextObject()) {
         $company = $db->Execute("SELECT id,title FROM `Obsedb_companies` WHERE `id` = '$row->RELID'");
         echo "<li> <a href=\"companies.php?do=viewid=".$company->fields['id']."\">", clean($company->fields['title']), "</a></li>";
         }
      }
   echo '</ul>';

   }

// #########################################
// Determines if content is dynamic, sort of
// #########################################
function setCache($value) {

	/* if the value > 1, then we are to make sure the user is fetching fresh content */
	if ($value >= 1) {

		/* Date has expired, browser will get new content */
		header("Expires: Sat, 01 Jan 2000 00:00:01 GMT");
		
		/* Content is rated as dynamic, and always modified */
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

		/* if the value is 2, then the user won't cache pages */
		if ($value == 2) {

			/* HTTP 1.1.  Tells browser not to store the page */
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
		
			/* HTTP 1.0.  Tells browser not to store the page */
			header("Pragma: no-cache");

		}

	}
	/* That's it.  Code based on code at php.net */

}

class Obsedb 
{

    var $config;

    function buildConfig()
    {
        global $db;
        
        $result = $db->Execute("
            SELECT config.id, config.key, config.value
            FROM Obsedb_configuration AS config;");
        
        while( $row = $result->FetchNextObject() )
        {
            $this->config["$row->KEY"] = stripslashes($row->VALUE);
        }
        
    }
    
	function getParam( $var )
	{
	    $var = $_REQUEST["$var"];
	    $var = mysql_real_escape_string($var);
	    return $var;
	}
}
?>