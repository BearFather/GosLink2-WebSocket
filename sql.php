<?php
//Function to retrieve data
//
//$info=array("localhost","user","password","db","table");
//$whre="" leave blank for all, or a where statement. 
//sqlg($info,$whre);
$whre="";
function sqlg($nf,$whre){
	//Getting variables
	$saddy=$nf[0];
	$susr=$nf[1];
	$spw=$nf[2];
	$sdb=$nf[3];
	$stb=$nf[4];
	if (isset($whre)){$wher=$whre;}
	else{$wher="";}
	//getting info from SQL
	mysql_connect($saddy,$susr,$spw);
	@mysql_select_db($sdb) or die( "Unable to select database");
	$query="SELECT * FROM ".$stb." ".$wher;
	$results=mysql_query($query);
	mysql_close();
	//Giving back results
	return $results;
}
// requires full select statement
function sql2g($nf,$whre){
        //Getting variables
        $saddy=$nf[0];
        $susr=$nf[1];
        $spw=$nf[2];
        $sdb=$nf[3];
        $stb=$nf[4];
        $wher=$whre;
        //getting info from SQL
        mysql_connect($saddy,$susr,$spw);
        @mysql_select_db($sdb) or die( "Unable to select database");
        $query=$wher;
        $results=mysql_query($query);
        mysql_close();
        //Giving back results
        return $results;
}

//Function to write data
//
//$info=array("localhost","usr","password","db","table");
//$value=array("value1","value2","and so on");
//$howmany=2; how many values?
//$data=array("col1","col2","and so on");
//sqlw($howmany,$value,$info);

function sqlw($amt,$vue,$nf,$dta){
	//Getting connect info
        $saddy=$nf[0];
        $susr=$nf[1];
        $spw=$nf[2];
        $sdb=$nf[3];
        $stb=$nf[4];
	//Populating SQL Line
	$data="";
	$wstr="";
	$i=0;
        while ($i < $amt){
                $data=$data.", ".$dta[$i];
                $wstr=$wstr.", '".$vue[$i]."'";
        $i++;
        }
        $data=substr($data, 2);
        $wstr=substr($wstr, 2);
	//Writing info to SQL DB
        mysql_connect($saddy,$susr,$spw);
        @mysql_select_db($sdb) or die( "Unable to select database");
	$query="INSERT INTO ".$stb." (".$data.") VALUES (".$wstr.")";
	$result=mysql_query($query);
	mysql_close();
	return $result;
}

//Function to update data
//
//$info=array("localhost","usr","password","db","table");
//$value=array("value1","value2","and so on");
//$data=array("col1","col2","and so on");
//$id=array("field to check","value to check");
//sqlu($value,$data,$id,$info);

function sqlu($vue,$data,$id,$nf){
	//Getting connect info
        $saddy=$nf[0];
        $susr=$nf[1];
        $spw=$nf[2];
        $sdb=$nf[3];
        $stb=$nf[4];
	//Writing info to SQL DB
        mysql_connect($saddy,$susr,$spw);
        @mysql_select_db($sdb) or die( "Unable to select database");
	$query="UPDATE ".$stb." SET ".$data."='".$vue."' where ".$id[0]."=".$id[1];
	$result=mysql_query($query);
	mysql_close();
	return $result;
}

//Function to delete records
//
//$info=array("localhost","root","sql","web","time");
//$rec=array(2,5);
//$stype="idv"; Can be "group" or "idv"
//echo sqld($stype,$rec,$info)

function sqld($tpe,$rec,$nf){
        $saddy=$nf[0];
        $susr=$nf[1];
        $spw=$nf[2];
        $sdb=$nf[3];
        $stb=$nf[4];
        mysql_connect($saddy,$susr,$spw);
        @mysql_select_db($sdb) or die( "Unable to select database");
	if($tpe == "group"){
		$strt=$rec[0];
		$endg=$rec[1];
		$i=$strt;
		while ($i <= $endg) {
			$query1 = "DELETE FROM ".$stb." WHERE id=".$i;
		        $results=mysql_query($query1);
		        $i++;
		}
	}
	if($tpe == "multi"){
		foreach ($rec as $value){
			$query1 = "DELETE FROM ".$stb." WHERE id=".$value;
		        $results=mysql_query($query1);
		}
	}
	elseif($tpe == "idv"){
 		foreach($rec as $value){
			$query1 = "DELETE FROM ".$stb." WHERE id=".$value;
			$results=mysql_query($query1);
		}
	}
	else{$results="bad type";}
	mysql_close();
	return $results;
}


?>

