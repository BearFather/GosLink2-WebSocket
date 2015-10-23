<html>
<body id="body" OnLoad="document.chatform.smess.focus();">
<link rel="stylesheet" type="text/css" href="style.css" />
<?php
$sqlinfo=array();

// EDIT THESE LINES
$sqlinfo['address']="localhost";
$sqlinfo['user']="sqluser";
$sqlinfo['password']="sqlpassword";
$sqlinfo['db']="gosbot";
$sqlinfo['table']="goschat";
// DONE EDITING

if (isset($_GET['uid'])){
	$id=$_GET['uid'];
	$name=$_GET['name'];
}else{
	$id=$_POST['id'];
	$name=$_POST['name'];
}
//dumping spaces to open up the flush buffer.
echo str_repeat(" ", 1024), "\n";
require('sql.php');
// !!!Start of functions.
//function to display our chat input
function formit($name,$id){
	echo "<FORM NAME =chatform METHOD =POST ACTION = input.php>";
	echo "<INPUT TYPE=hidden VALUE=".$id." name=id>";
	echo "<input type='hidden' VALUE=".$name." name=name />";
	echo "<INPUT TYPE=TEXT VALUE='' name=smess size=85>";
	echo "<INPUT TYPE = Submit Name = sayit id=chatbutton VALUE ='Say it'>";
	echo "</form>";
}
// End of Functions!!!

//if message was sent and has a message.
if (isset($_POST['name']) && $_POST['smess'] != "") {
	$info=array($sqlinfo['address'],$sqlinfo['user'],$sqlinfo['password'],$sqlinfo['db'],$sqlinfo['table']);
	$smess=$_POST['smess'];
	$tgt="public";
	// getting rid of the 's sql hates them
	$smess=ereg_replace("'","",$smess);
	$dta=array("msg","trgt","user","id");
	$value=array($smess,$tgt,$name,$id);
	$howmany=4;
	//sending message to sql
	sqlw($howmany,$value,$info,$dta);
	formit($name,$id);
}
//if the button was pressed and no message redisplay the form.
elseif (isset($_POST['name'])){
	formit($name,$id);
}
else{formit($name,$id);}
?>
</body>
</html>
