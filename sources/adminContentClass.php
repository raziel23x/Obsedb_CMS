<?php

class Module
{

    var $phrase;
    
    function initForm()
    {
        global $cp;
        
        $do = $cp->getParam( 'do' );
        $this->phrase = $cp->getPhrases( 'adminContent' );
        
        $cp->header();
        $this->header();
        
        switch( $do )
        {
            case 'import_Mod':
                $this->import_Mod();
                break;
            default:
                $this->main();
                break;
        }
        
        $cp->footer();
    }

    function header()
    {
        global $db;

        $links = '<!-- No Links -->';

        do_module_header($this->phrase['module_header'],$links,'content');
    }

    function main()
    {
        global $db;
		do_table_header("Obsedb CMS Mod Library");
		print "<tr><td style=\"background: #fff;\">";
        

        $phpVersion = phpversion();
        
        if ( $phpVersion >= 5 )
        {
            print '<h3 style="padding-left: 5px;"><span style="color: green;">Beta</span></h3>';
            if (!isset($_REQUEST['platform']))
            {
                $xmlfile = simplexml_load_file('http://content.Obsedbcms.com/platforms.xml');
                foreach ($xmlfile AS $platform)
                {
                    print '<div style="font-size: 10pt; padding: 10px; width: 300px; background-color: #fff; border: 1px solid #f5f5f5;">';
                    print '<a href="content.php?platform='.$platform->var.'">'.$platform->title.'</a>';
                    print '</div><br />';
                }
            } else {

                $xmlfile = simplexml_load_file('http://content.Obsedbcms.com/'.$_REQUEST[platform]);
                foreach ($xmlfile AS $Mod)
                {
                    print '<div style="padding: 10px; width: 300px; background-color: #fff; border: 1px solid #f5f5f5;">';
                    print '<div style="font-size: 10pt;">'.$Mod->title.'</div>';
                    print '<a href="content.php?do=import_Mod&Mod='.$Mod->url.'">Import Mod</a>';
                    print '</div><br />';
                }
            }
            
        } else {
            print '<h3 style="margin: 0px;"><span style="color: green;">Error</span></h3>';
            print "You must have PHP version 5 or greater to access the content download system.";     
                
        }
        print "</td></tr>";
        
        
        do_table_footer();
    }

    function import_Mod()
    {
        global $db;

        print '<h2><b>Obsedb CMS Mod Library</b></h2>';
        print '<h3><span style="color: green;">Beta</span></h3>';

        $xmlfile = simplexml_load_file('http://content.Obsedbcms.com/'.$_REQUEST['Mod']);
        foreach ($xmlfile AS $Mod)
        {
            $result = $db->Execute("SELECT * FROM Obsedb_Mods_sections WHERE `title` = '$Mod->platform' LIMIT 1");
				if ($result->RecordCount() == 0)
				{
					$db->Execute("INSERT INTO Obsedb_Mods_sections (title) VALUES ('$Mod->platform')") or die($db->ErrorMsg());
					$platform = $db->Insert_ID() or die($db->ErrorMsg());
				}
            while ($row = $result->FetchNextObject())
            {
					$platform = $row->ID;
            }
			$rs = $db->Execute("SELECT * FROM `Obsedb_Mods` WHERE `id` = '-1';");
            $record['title'] = $Mod->title;
            $record['section'] = $platform;
            $record['published'] = '1';
            print $Mod->title . "<br />";
            $sql = $db->GetInsertSQL($rs,$record);
            $result = $db->Execute($sql) or die ($db->ErrorMsg());
        }
    }


}

?>