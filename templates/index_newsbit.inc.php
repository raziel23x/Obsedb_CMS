<?php

/**
*    ========================
*    CONFIGURATION VARIABLES
*    ========================
*/

/* Number of news items to show on frontpage */
$cfglimit = '10';

/**
*    ========================
*    END CONFIGURATION
*    ========================
**/
global $spconfig;
$limit = $spconfig['frontpage_news_limit'];

if ($result) {
  unset($result);
  }
  
$result = $db->Execute("
  SELECT news.id, news.title, news.intro, news.date, news.author, news.newsimage, sections.title AS section
  FROM Obsedb_news AS news, Obsedb_news_sections AS sections
  WHERE news.section = sections.id
  ORDER BY news.date DESC LIMIT 0, $limit;") or die($db->ErrorMsg());

while ($NewsRow = $result->FetchNextObject()) 
{

?>
<div class='alt1'>
<div class='alt1_top'><img src='images/corners/alt1_tlc.gif' width='10' height='10' class='corner' style='display: none;'></div>
<p>
<b><a href="index.php?do=viewarticle&id=<?php echo $NewsRow->ID; ?>"><?php echo stripslashes($NewsRow->TITLE); ?></a></b><br />
	Category: <?php echo stripslashes($NewsRow->SECTION); ?> |
	Posted on <?php echo stripslashes($NewsRow->DATE); ?>
	by <?php echo stripslashes($NewsRow->AUTHOR); ?><br /><br />



<table border="0" cellspacing="0" cellpadding="0" width="100%" style="padding-left: 30px; padding-right: 30px;">
	<tr>
           <?php
           if (!empty($NewsRow->NEWSIMAGE))
           {
               echo '<td align="center" valign="top" style="padding: 5px;">
                     <img src="images/news_icons/' . $NewsRow->NEWSIMAGE . '" />
                     </td>';
           }
           ?>
	   <td width="100%" valign="top">
	      <?php echo clean($NewsRow->INTRO); ?>

	   </td>
	</tr>
	</table>
  <div style="text-align: right; padding-right: 10px; font-weight: bold;">
    <a href="index.php?do=viewarticle&id=<?php echo $NewsRow->ID; ?>">Read more</a>
  </div>
	</p>
	<div class='alt1_bottom'><img src='images/corners/alt1_blc.gif' width='10' height='10' class='corner' style='display: none;'></div>
	</div><br />
<?php } ?>



