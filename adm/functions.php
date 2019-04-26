<?php
	if ( !defined( "FILE" ) ) die( "Illegal File Access" );

	function save_conf( $fp, $content, $op ) 
	{
		if ( file_exists( $fp ) && $content ) 
		{
			$fp = fopen( $fp, "wb" );
			$content = ( $op ) ? $content : "<?php\nif (!defined(\"FILE\")) die(\"Illegal File Access\");\n\n".$content."\n?>";
			fwrite( $fp, $content );
			fclose( $fp );
		}
	}

	function user_geo_ip($ip, $id) 
	{
		global $conf, $lang;
		if ( ( phpversion() >= "5" ) && $ip ) 
	{
		include_once( "geo_ip.php" );
		$geoip = geo_ip::getInstance( "geo_ip.dat" );
		if ( $id == 1 ) 
		{
			$cont = $geoip -> lookupCountryCode( $ip );
		} 
			elseif ( $id == 2 ) 
		{
			$cont = $geoip -> lookupCountryName( $ip );
		} 
			elseif ( $id == 3 ) 
		{
			$name = $geoip -> lookupCountryName( $ip );
			$img = str_replace(" ", "_", strtolower( $name ) );
			if ( file_exists( "img/".$img.".png" ) ) 
			{
				//$cont = "<img src=\"img/".$img.".png\" border=\"0\" alt=\"".$lang[$conf['lang']]['table_country'].": ".$name."\" title=\"".$lang[$conf['lang']]['table_country'].": ".$name."\">";
			} 
			else 
			{
				//$cont = "<img src=\"img/question.png\" border=\"0\" alt=\"".$lang[$conf['lang']]['table_country'].": ".$name."\" title=\"".$lang[$conf['lang']]['table_country'].": ".$name."\">";
			}
		} 
		elseif ( $id == 4 ) 
		{
			$name = $geoip -> lookupCountryName( $ip );
			$img = str_replace(" ", "_", strtolower( $name ) );
			if ( file_exists("img/".$img.".png" ) ) 
			{		
				$cont = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
							<tr>
								<td width=\"18\" height=\"18\">
									<img src=\"img/".$img.".png\">
								</td>
								<td>
									$ip
								</td>
							</tr>
						</table>";

			} 
			else 
			{
				$cont = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
							<tr>
								<td width=\"18\" height=\"18\">
									<img src=\"img/question.png\">
								</td>
								<td>
									$ip
								</td>
							</tr>
						</table>";

				}
			}
			return $cont;
		} 
		else 
		{
			return;
		}
	}

	function datetime( $id, $name, $time, $max, $size, $width, $class ) 
	{
		global $conf, $lang;
		static $jscript;
		$format = ( $id == 1 ) ? "%Y-%m-%d %H:%M" : "%Y-%m-%d";
		$showt = ($id == 1) ? true : false;
		if ( !isset( $jscript ) ) 
		{
			$content = "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/calendar.css\">\n";
			$content .= "<script type=\"text/javascript\" src=\"ajax/calendar/calendar.js\"></script>\n"
			."<script type=\"text/javascript\" src=\"ajax/calendar/lang/calendar-".substr($conf['lang'], 0, 2).".js\"></script>\n"
			."<script type=\"text/javascript\" src=\"ajax/calendar/calendar-setup.js\"></script>\n";
			$jscript = 1;
		} 
		else 
		{
			$content = "";
		}
	
		$content .= "<img src=\"img/calendar.png\" border=\"0\" align=\"center\" id=\"img_".$name."\" style=\"cursor: pointer;\" title=\"".$lang[$conf['lang']]['cal']."\"> <input type=\"text\" name=\"".$name."\" id=\"".$name."\" value=\"".$time."\" maxlength=\"".$max."\" size=\"".$size."\" style=\"width: ".$width."px\" class=\"".$class."\">"
		."<script type=\"text/javascript\">
		 Calendar.setup(
		 {
			inputField: \"".$name."\",
			ifFormat: \"".$format."\",
			showsTime: \"".$showt."\",
			button: \"img_".$name."\",
			singleClick: true,
			step: 1
		 });
		 </script>";
		return $content;
	}

	function format_time( $time ) 
	{
		global $conf, $lang;
		setlocale( LC_TIME, $lang[$conf['lang']]['locale'] );
		preg_match( "/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $time, $datetime );
		$datetime = mktime( $datetime[4], $datetime[5], $datetime[6], $datetime[2], $datetime[3], $datetime[1] );
		return $datetime;
	}

	function make_synch( $last_online ) 
	{
		global $lang, $conf;
		$last_online = intval( $last_online );
		$time = time();
		$time = $time - $last_online;
		if ( $time < 60 ) 
		{
			$cont = $time." ".$lang[$conf['lang']]['sec_ago'];
		} 
		elseif ( $time < 3600 ) 
		{
			$time = $time / 60;
			$time = intval( $time );
			$cont = $time." ".$lang[$conf['lang']]['min_ago'];
		} 
		elseif ( $time < 86400 ) 
		{
			$time = $time / 3600;
			$time = intval( $time );
			$cont = $time." ".$lang[$conf['lang']]['hour_ago'];
		} 
		elseif ( $time > 86400 ) 
		{
			$time = $time / 86400;
			$time = intval( $time );
			$cont = $time." ".$lang[$conf['lang']]['day_ago'];
		}
		return $cont;
	}

	function make_stat_simp() 
	{
		$return = array();
		$timeout = make_timeout();
		$timeout_day = time() - 86400;
		$timeout_month = time() - ( 30 * 86400 );
		
		$query = mysql_query( "SELECT COUNT(id) AS onlinebots FROM bots WHERE last_online > '$timeout'" );
		list( $onlinebots ) = mysql_fetch_array( $query );
		
		$query = mysql_query( "SELECT COUNT(id) AS onlinebots FROM bots WHERE last_online > '$timeout_day'" );
		list( $todaybots ) = mysql_fetch_array( $query );		
		
		$query = mysql_query( "SELECT COUNT(id) AS onlinebots FROM bots WHERE last_online > '$timeout_month'" );
		list( $tomonthbots ) = mysql_fetch_array( $query );
		
		$query = mysql_query( "SELECT COUNT(id) AS allbots FROM bots" );
		list( $allbots ) = mysql_fetch_array( $query );
		
		$return[1] = intval( $onlinebots );
		$return[2] = intval( $allbots );
		$return[3] = intval( $todaybots );
		$return[4] = intval( $tomonthbots );
		
		return $return;
	}
?>