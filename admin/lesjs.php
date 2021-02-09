<?php
include_once('../dev/db.php');
$dbconnect = new dbconnection();
$action = $_POST['action'];

if ($action=='select')
{
	$sql="SELECT * FROM lessen WHERE les_id=:id";
	$query = $dbconnect -> prepare($sql);
	$query->bindParam(":id", $_POST['les_id']);
	$query ->execute();	
		
	$les=$query->fetchAll(PDO::FETCH_ASSOC);
	//$returnstmt="<pre>".print_r($les)."</pre>";
	$returnstmt="<form id='lesform' onsubmit=\"updateLes(".$les[0]['les_id'].");return false;\">";
	$returnstmt.="<div class='form-row'>";
	$returnstmt.="<div class='form-group col-md-2'>";
	$returnstmt.="<label for='behlesnr'>Lesnr Beh</label>";
	$returnstmt.="<input id='behlesnr' class='form-control' type='text' value='".$les[0]['les_behlesnr']."'>";
	$returnstmt.="</div>";
	$returnstmt.="<div class='form-group col-md-3'>";
	$returnstmt.="<label for='behdatum'>Datum Beh</label>";
	$returnstmt.="<input id='behdatum' class='form-control' type='text' value='".$les[0]['les_behdatum']."'>";
	$returnstmt.="</div>";
	$returnstmt.="<div class='form-group col-md-2'>";
	$returnstmt.="<label for='aolesnr'>Lesnr AO</label>";
	$returnstmt.="<input id='aolesnr' class='form-control' type='text' value='".$les[0]['les_aolesnr']."'>";
	$returnstmt.="</div>";
	$returnstmt.="<div class='form-group col-md-3'>";
	$returnstmt.="<label for='aodatum'>Datum AO</label>";
	$returnstmt.="<input id='aodatum' class='form-control' type='text' value='".$les[0]['les_aodatum']."'>";
	$returnstmt.="</div>";
	$returnstmt.="</div>";
	$returnstmt.="<div class='form-group'>";
	$returnstmt.="<label for='docent'>Docent</label>";
	$returnstmt.="<textarea id='docent' class='form-control' rows='5'>".$les[0]['les_methode']."</textarea>";
	$returnstmt.="</div>";
	$returnstmt.="<div class='form-group'>";
	$returnstmt.="<label for='lesdoel'>Doel</label>";
	$returnstmt.="<textarea id='lesdoel' class='form-control' rows='5'>".$les[0]['les_doel']."</textarea>";
	$returnstmt.="</div>";
	$returnstmt.="</form>";
	echo json_encode($returnstmt);
}
elseif($action=="update")
{
	if(dbConnect())
	{
		$sql="UPDATE lessen SET 
		les_behlesnr=:lesnrbeh, 
		les_behdatum=:datumbeh, 
		les_aolesnr=:lesnrao, 
		les_aodatum=:datumao, 
		les_methode=:docent, 
		les_doel=:doel 
		WHERE les_id=:id";
		dbQuery($sql,[':lesnrbeh'=>$_POST['behlesnr'],':datumbeh'=>$_POST['behdatum'],':lesnrao'=>$_POST['aolesnr'],':datumao'=>$_POST['aodatum'],':docent'=>$_POST['docent'],':doel'=>$_POST['lesdoel'],':id'=>$_POST['lesid']]);
	}
}
elseif($action=="insert")
{
	if(dbConnect())
	{
		$sql="INSERT INTO lessen (les_behlesnr, les_behdatum, les_aolesnr, les_aodatum, les_methode, les_doel) VALUES (:lesnrbeh, :datumbeh, :lesnrao, :datumao, :docent, :doel)";
		dbQuery($sql,[':lesnrbeh'=>$_POST['behlesnr'],':datumbeh'=>$_POST['behdatum'],':lesnrao'=>$_POST['aolesnr'],':datumao'=>$_POST['aodatum'],':docent'=>$_POST['docent'],':doel'=>$_POST['lesdoel']]);
	}
}
elseif ($action=='select_opg')
{
	if(dbConnect())
	{
		$sql="SELECT * FROM opgaven WHERE opg_id=:id";
		//$paramaters=array(':id' => $_POST['opg_id']);
		dbQuery($sql,[':id'=>$_POST['opg_id']]);
		
		$les=dbGetAll();
		//$returnstmt="<pre>".print_r($les)."</pre>";
		$returnstmt="<form id='opgform' onsubmit=\"updateOpg(".$les[0]['opg_id'].");return false;\">";
		$returnstmt.="<div class='form-group'>";
		$returnstmt.="<label for='opgave'>Opgave(n)</label>";
		$returnstmt.="<textarea id='opgave' class='form-control'>".$les[0]['opg_opgaven']."</textarea>";
		$returnstmt.="</div>";
		$returnstmt.="<div class='form-group'>";
		$returnstmt.="<label for='opg_url'>Math4All-link</label>";
		$returnstmt.="<textarea id='opg_url' class='form-control'>".$les[0]['opg_url']."</textarea>";
		$returnstmt.="</div>";
		$returnstmt.="</form>";
	}
	echo json_encode($returnstmt);
}
elseif($action=="insert_opg")
{
	if(dbConnect())
	{
		$sql="INSERT INTO opgaven (opg_les_id, opg_opgaven, opg_url) VALUES (:id, :opg, :url)";
		dbQuery($sql,[':id'=>$_POST['les_id'], ':opg'=>$_POST['opg'],':url'=>$_POST['url']]);
	}
}

elseif($action=="delete")
{
	if(dbConnect())
	{
		$sql="DELETE FROM lessen WHERE les_id=:lesid";
		dbQuery($sql,array(':lesid'=>$_POST['les_id']));
	}
}

elseif($action=="delete_opg")
{
	if(dbConnect())
	{
		$sql="DELETE FROM opgaven WHERE opg_id=:opgid";
		dbQuery($sql,array(':opgid'=>$_POST['opg_id']));
	}
}

elseif($action=="update_opg")
{
	if(dbConnect())
	{
		$sql="UPDATE opgaven SET 
		opg_opgaven=:opgave, 
		opg_url=:opgurl
		WHERE opg_id=:id";
		dbQuery($sql,[':opgave'=>$_POST['opg_tekst'],':opgurl'=>$_POST['opg_url'],':id'=>$_POST['opg_id']]);
	}
}
?>