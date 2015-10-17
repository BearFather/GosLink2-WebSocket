<?php session_start(); ?>
<html>
<body id="body">
<link rel="stylesheet" type="text/css" href="style.css" />
<?php
if(isset($_POST['name'])){
	$name = $_POST['name'];
	$uid=rand(11,99).rand(11,99);
	print("<h1>Bear's BBS Web Chat</h1>");
	print("<iframe id=chat src='output.php?name=".$name."&uid=".$uid."' width=620 height=425 marginwidth=0 marginheight=0 hspace=0 vspace=0 frameborder=0 scrolling=auto><br></iframe><br>");
	print("<iframe id=input src='input.php?name=".$name."&uid=".$uid."' width=620 height=60 marginwidth=0 marginheight=0 hspace=0 vspace=0 frameborder=0 scrolling=no></iframe>");
	print("</html>");
}else{
        echo "<FORM NAME =userform METHOD =POST ACTION =''>";
        echo "<input type='text' VALUE='' name=name />";
        echo "<INPUT TYPE = Submit Name = login id=chatbutton VALUE ='Login'>";
        echo "</form>";
}
?>
