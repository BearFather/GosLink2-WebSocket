<?php session_start(); ?>
<html>
<body id="body">
<link rel="stylesheet" type="text/css" href="style.css" />
<?php
//Set your user tag here..I use php digest.
require('sql.php');
$name = "Webuser";
$uid=rand(11,99).rand(11,99);
$euser="none";
$info=array("localhost","root","sql","gosbot","webuser");
$value=array($uid,$name,$euser);
$howmany=3;
$data=array("uid","user","euser");
sqlw($howmany,$value,$info,$data);
print("<h1>Bear's BBS Web Chat</h1>");
//print("<iframe id=users src='lib/users.php?blah=blah' width=120 height=200 marginwidth=0 marginheight=0 hspace=0 vspace=0 frameborder=0 scrolling=no></iframe>");
print("<iframe id=chat src='output.php?name=".$name."&uid=".$uid."' width=620 height=425 marginwidth=0 marginheight=0 hspace=0 vspace=0 frameborder=0 scrolling=auto><br></iframe><br>");
print("<iframe id=input src='input.php?name=".$name."&uid=".$uid."' width=620 height=30 marginwidth=0 marginheight=0 hspace=0 vspace=0 frameborder=0 scrolling=no></iframe>");
//print("<iframe id=players src=lib/player.php width=800 height=345 marginwidth=0 marginheight=0 hspace=0 vspace=0 frameborder=0 scrolling=no></iframe>");
print("</html>");
?>
