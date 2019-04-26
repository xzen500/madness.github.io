<?php

   define("FILE", true);
   include("../inc/config.php");
   include("../inc/lang.php");
   @session_start();

   if ( $_POST['password'] && $_POST['username'] ) 
   {
	   $sess_pass = htmlspecialchars($_POST['password']);
	   $sess_name = htmlspecialchars($_POST['username']);
	   if ( $sess_pass == $conf['adpass'] && $sess_name == $conf['adname'] ) 
	   {
		  $_SESSION['password'] = $conf['adpass'];
		  $_SESSION['alang'] = $_POST['alang'];
		  $_SESSION['sess_type'] = md5( $conf['adpass'] );
		  header("Location: index.php");
	   } 
	   elseif ( $sess_pass == $conf['gupass'] && $sess_name == $conf['guname'] ) 
	   {
		  $_SESSION['password'] = $conf['gupass'];
		  $_SESSION['alang'] = $_POST['alang'];
		  $_SESSION['sess_type'] = "guest";
		  header("Location: index.php");
	   } 
	   else 
	   {
		  header("Location: auth.php");
	   }
   } 
   else 
   {
	  $content = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n"
	  ."<html>\n"
	  ."<head><body background=\"img/bc.jpg\"> \n"
	  ."<meta http-equiv=\"content-type\" content=\"text/html; charset=".$lang[$language]['charset']."\">\n"
	  ."<title>Madness Control Center</title>\n"
	  ."<link rel=\"shortcut icon\" href=\"favicon.ico\" />"
	  ."<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\">"
	  ."<script type=\"text/javascript\">
		   function changelang(tlang) 
		   {
			  var hfield = document.getElementById('hfield');
			  var hlang = document.getElementById('tlang');
			  var hbut = document.getElementById('lbut');
			  hfield.value = tlang;
			  if (tlang == 'en') 
			     {
				    hlang.innerHTML = \"English\";
				    hbut.value = \"Enter\";
			     } 
				 else 
				 {
				    hlang.innerHTML = \"Russian\";
				    hbut.value = \"Войти\";
			     }
		   }
	</script>"
	."</head>".
		"
		<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" height=\"100%\" >
		<tr>
		<td width=\"150\"></td>
		<td>
		<p align=\"center\">
		
		
		<form id=\"form1\" name=\"form1\" method=\"post\" action=\"auth.php\">
		<p align=\"center\">
		<img src=\"img/madness.png\" border=\"0\">
		</p>
		<label>
		
		
		<div align=\"center\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id=\"aura\" >
		<tr>
			<td background=\"img/top-left.png\"></td>
			<td height=\"24\" background=\"img/top.png\"></td>
			<td background=\"img/top-right.png\"></td>
		</tr>
		<tr>
			<td width=\"24\" background=\"img/left.png\"></td><td>
			
			
			
		
		<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
	<tr>
		<td align=\"center\">
	
			
		<input class=m4 size=\"161\" type=\"text\" name=\"username\">
		
		
	
		
		</td>
	</tr>

	<tr>
		<td height=\"5\">
		</td>
	</tr>	
	
	<tr>
		<td align=\"center\">
	
		<input class=m4 size=\"161\" type=\"password\" name=\"password\">
			
		</td>
	</tr>

	
	</table>
		
		
			</td><td width=\"24\" background=\"img/right.png\"></td>
		</tr>
		<tr>
			<td background=\"img/buttom-left.png\"></td>
			<td height=\"24\" background=\"img/buttom.png\"></td>
			<td background=\"img/buttom-right.png\"></td>
		</tr>
	    </table>	
		
		
       
		
		</label>
		
		<label>"

		.
		"</label>
		
		
		<div align=\"center\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id=\"aura\" >
		<tr>
			<td background=\"img/top-left.png\"></td>
			<td height=\"24\" background=\"img/top.png\"></td>
			<td background=\"img/top-right.png\"></td>
		</tr>
		<tr>
			<td width=\"24\" background=\"img/left.png\"></td><td>
			
			
		
		<input class=cssbutton type=\"submit\" id=\"lbut\" name=\"Submit\" value=\"Enter\">
		
		
		</td><td width=\"24\" background=\"img/right.png\"></td>
		</tr>
		<tr>
			<td background=\"img/buttom-left.png\"></td>
			<td height=\"24\" background=\"img/buttom.png\"></td>
			<td background=\"img/buttom-right.png\"></td>
		</tr>
	    </table>
		
		
		
		
		
		
		
		
</td>
		<td width=\"150\" valign=\"top\">
		<p align=\"center\">
		
		
		
		
		
		
		<input type=\"hidden\" value=\"\" id=\"hfield\" name=\"alang\">
		
		
		
		<a href=\"#\" onclick='changelang(\"en\")'><img src=\"img/english.png\" width=\"30\" height=\"24\" alt=\"English\" border=\"0\"></a>
		<a href=\"#\" onclick='changelang(\"ru\")'><img src=\"img/russian.png\" width=\"30\" height=\"24\" alt=\"Russian\" border=\"0\"></a>
		<br>
		Language: <b><span id=\"tlang\">Default</span></b>		
		
		</p>
		
		</form>
		
		
		</td>
	</tr>
	<tr>
		<td colspan=\"3\" height=\"20\">
		<p align=\"center\">"
		
		."<p align=\"center\">Madness system & Madness control panel © 2013 by C++ GURU team, based on sw^team product 2009-".date('Y')."</p>".
		
		"</td>
	</tr>
</table>

		
		
		"

	."</body>\n"
	."</html>";
	echo $content;
}
?>
