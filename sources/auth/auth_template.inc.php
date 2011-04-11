<?php
/************************************************************************/
/* PWZ_AUTH v2.2      	                                                */
/* ===================================                                  */
/* this file : release 1.1                                              */
/*                                                                      */
/* http://opensource.spidmail.net                                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the BSD License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
 
function pwz_tpl ( $d, $f ) {
	$template_path = $d . "/" . $f; //Build file path
	if(file_exists($template_path))
	{	
		$fd = @fopen($template_path, "r");
		$template=@fread($fd, filesize($template_path));
		fclose($fd);
	} else {
    		trigger_error("Unable to locate templates files");
    	}
	// coeur du systeme
	$tpl_len=strlen($template);
	$o=""; //output HTML & PHP
	//parser des tags
	for($aa=0;$aa<$tpl_len;$aa++)
	{	// tag suivant
		$tagO=strpos($template,"<%",$aa);
		
		if ($tagO===false) 
		{	// plus de tag
			$o.=substr($template,$aa);
			break;
		} else {
			//recupere la fin du tag
			$tagC=strpos($template,"%>",$tagO);
			$tag=substr($template,$tagO+2,$tagC-$tagO-2);
			//on ajoute le html
			$o.=substr($template,$aa,$tagO-$aa);
			//on traite le tag en question
			if ($tag=="self")
				$o.=$_SERVER['PHP_SELF'];
			else {
				$value=$tag;
				global $$value;
				$o.=$$value;
			}
			//au suivant
			$aa=$tagC+1;
		}
	}
	// on retourne le tout parser
	return $o;
}
?>