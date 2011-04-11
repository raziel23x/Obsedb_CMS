<form method="post" action="search.php">
<table border="0" cellspacing="0" cellpadding="6" width="100%">
   <tr>
      <td style="border: 1px solid #C0C0C0;" bgcolor="#F1F1F1">
         <b>Search Mods</b><br />
         <table border="0" cellspacing="10" cellpadding="0">
            <tr>
               <td><b>Keywords:</b> </td><td colspan="2"><input type="text" name="keywords" size="20"></td>
            </tr>
            <tr>
               <td><b>Platform:</b> </td><td colspan="2"><input type="radio" name="platform" value="all" checked="checked"> All</td>
            </tr>
            <tr>
               <?
                  $count = 0;
                  $sections = FetchSections('Obsedb_Mods_sections');
                  foreach ($sections AS $key => $value) {
                     $count++;
                     echo "<td><input type='radio' name='platform' value='$key'> " . stripslashes($value) . "</option>\n";
                     if ($count >= 3) {
                        echo "</tr><tr>";
                        $count = 0;
                        }

                  }
               ?>
               </select>
               </td>
            </tr>
            <tr>
               <td colspan="3"><b>Matching:</b></td>
            </tr>
            <tr>
               <td><input type="radio" name="exact" value="1"> Exact Match</td>
               <td colspan="2"><input type="radio" name="exact" value="0" checked> Partial Match</td>
            </tr>
            <tr>
               <td colspan="3"><input type="submit" name="submit" value="Search"></td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<input type="hidden" name="do" value="search_Mods">
</form>