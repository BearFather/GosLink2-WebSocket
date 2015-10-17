<html>
<head>
</head>
<body id=body>
<link rel="stylesheet" type="text/css" href="style.css" />
<?php
require('sql.php');
$server=array();
$server['h']='192.168.1.101';
$server['p']=3000;
$user="webbot";
$pass="pass";
$name=$_GET['name'];
$connected=false;

$id=$_GET['uid'];
echo str_repeat(" ", 1024), "\n";//dumping spaces to open up the flush buffer.

function write($cmd,$server){fwrite($server['s'], $cmd."\n");}
function read($server){return fgets($server['s'],1024);}
function login($server){
	$connected=true;
	read($server,":!:user:!:");
	write(":!:user:!:".$GLOBALS['user'],$server);
	read($server,":!:pass:!:");
	write(":!:pass:!:".$GLOBALS['pass'],$server);
	read($server,":!:name:!:");
	write($GLOBALS['name'],$server);
	read($server,":!:connected:!:");
	write("hello",$server);
	$GLOBALS['connected']=true;
}
function disPlayers($line){
	$a=explode(":",$line);
	$sName=$a[0];
	$players=$a[1];
	echo "<br>-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-<br>";
	echo "<table><tr><td></td><td></td><td>	";
	echo "<span id=who>".$sName.":</span></td></tr>";
	$b=explode(",",$players);
	$c=0;
	echo "<tr>";
	foreach ($b as $value){
		echo "<td>".$value."</td>";
		$c++;
		if ($c>4){echo "</tr><tr>";$c=0;}
	}
	echo "</tr></table>";
}
function readon($server){
	while ($GLOBALS['connected']){
		$line=read ($server);
		$line=trim($line);
		if ($line!=""){
			if (strpos($line,":!:ping:!:")!== false){write(":!:pong:!:",$server);}
			else if (strpos($line,":!:hangup:!:")!== false){$GLOBALS['connected']=false;}
			else if (strpos($line,":!:players:!:")!== false){disPlayers(substr($line,13));}
			else if (strpos($line,":!:info:!:")!== false){echo "<span id=info>".substr($line,10)."</span><br>";}
			else{echo "<span id=gos>".$line."</span><br>";}
		}
		checkSql($server);
		ob_flush();
		flush();
		sleep(1);
	}
}
function checkSql($server){
	if ($GLOBALS['connected']){
		$info=array("localhost","root","sql","gosbot","goschat");
		$rtn=sqlg($info,"where id=".$GLOBALS['id']);
		$delete=0;
		if (mysql_num_rows($rtn) != 0){
		        $a=0;
			$rec=array();
			//sorting the info from the sql
			while(mysql_numrows($rtn)>$a){
		                $sid[$a]=mysql_result($rtn,$a,"id");
		                $suser[$a]=mysql_result($rtn,$a,"user");
		                $smsg[$a]=mysql_result($rtn,$a,"msg");
		                $strgt[$a]=mysql_result($rtn,$a,"trgt");
				 // if a public message send to gossip
				if ($strgt[$a] == "public"&& $suser[$a]==$GLOBALS['name']){
					$shmsg=substr($smsg[$a],0,4);
					if ($shmsg=="gos "){$smsg[$a]=substr($smsg[$a],4);}
					write($smsg[$a],$server);
					echo "<span id=gos>You gossip: ".$smsg[$a]."</span><BR>";
					array_push($rec, $sid[$a]);
					$delete=1;
				}
	        		$a++;
			}
			$stype="multi";
			if ($delete==1){sqld($stype,$rec,$info);}
		}
	}
}
//begin connection
$server['s'] = fsockopen($server['h'], $server['p'], $errno, $errstr, 2);
if($server['s']){
	login($server);
	stream_set_blocking($server['s'], 0);
	if ($connected){readon($server);}
}
write(":!:hangup:!:",$server);
fclose($server['s']);
?>
</body>
</html>

