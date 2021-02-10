<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, array('Dutch_Netherlands', 'Dutch', 'nl_NL', 'nl', 'nl_NL.ISO8859-1'));
date_default_timezone_set('Europe/Amsterdam');
@include_once('../dev/db.php');
$groep="ao";
$groepdispl="SD";
if(isset($_GET['groep']))
	$groep=$_GET['groep'];

if($groep=="beh")
	$groepdispl="Beheer";

$vakid=2;
if(isset($_GET['vakid']))
	$vakid=$_GET['vakid'];


$dbconnect = new dbconnection();
$sql="SELECT * FROM vakken, lessen LEFT OUTER JOIN opgaven ON les_id = opg_les_id WHERE les_vakid=:vakid AND vak_id=les_vakid ORDER BY les_behdatum DESC";
$query = $dbconnect -> prepare($sql);
$query->bindParam(":vakid", $vakid);
$query ->execute();

$lessen = $query->fetchAll(PDO::FETCH_ASSOC);
	
	?>
<!DOCTYPE html>
<html lang="nl">
  <head>
	  <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="Ids Osinga">
<title>Wiskundeplanning</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.0.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/a293ef7e4c.js" crossorigin="anonymous"></script>
<script src="lesjs.js"></script>

<style>
        .modal_lg {
          width: 700px; /* New width for default modal */
        }
</style>
</head>
<body>
<div class="mai-wrapper">

<div class="container">	

<div id="detailsModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="modal-title" class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modal-body" class="modal-body"></div>
      <div id="modal-footer" class="modal-footer"></div>
    </div>
  </div>
</div>
<div class="row">
	<div class="col-lg-10"><h1><?= $lessen[0]['vak_naam'] ?>planning <?= $groepdispl ?>-groepen (OSD)</h1></div>
	<div class="col-lg-2" style="margin-top: 10px"><button class="btn btn-primary btn-block" onclick="addLes()">Voeg les toe</button></div>
</div>
	
<div class="table-responsive-xl">
<table class="table table-hover">
	<thead class="thead-dark">
    <tr>
	   <th scope="col"></th>
      <th scope="col" colspan="2">Datum Beh</th>
      <th scope="col" colspan="2">Datum AO</th>
      <th scope="col">Docent</th>
      <th scope="col">Doel</th>
      <th scope="col"></th>
    </tr>
  </thead>
<?php
	$vorigelesnr=0;
	$i=0;
	foreach($lessen as $les)
	{
		if($les['les_behlesnr']<>$vorigelesnr)
		{
			$datumbeh=strftime('%a %e %h' , strtotime($les['les_behdatum']));
			$datumao=strftime('%a %e %h' , strtotime($les['les_aodatum']));
			echo "<tr>";
			echo "<td class='text-right'><a href='#' onclick=\"editLes({$les['les_id']})\"><i class='fas fa-edit'></i></a></td>";
			echo "<td class='text-right' width='75'>Les ".$les['les_behlesnr']."</td>";
			echo "<td width='100'>".$datumbeh."</td>";
			echo "<td class='text-right' width='75'>Les ".$les['les_aolesnr']."</td>";
			echo "<td width='100'>".$datumao."</td>";
			echo "<td width='250'>".nl2br($les['les_methode'])."</td>";
			echo "<td colspan='1'>".nl2br($les['les_doel'])."</td>";
			echo "<td class='text-right'><a href='#' onclick=\"addOpg({$les['les_id']})\"><i class='fas fa-plus-circle'></i></a></td>";
			echo "</tr>";
			$vorigelesnr=$les['les_behlesnr'];
		}
		if(!is_null($les['opg_opgaven']))
		{
			echo "<tr><td class='text-right' colspan='2'><a href='#' onclick=\"editOpgave({$les['opg_id']})\"><i class='fas fa-edit'></i></a></td><td colspan='4'>{$les['opg_opgaven']}</td>";
			echo "<td colspan='3'><a href='{$les['opg_url']}' target='_blank'>{$les['opg_url']}</a></td>";
			echo "</tr>";
		}	
	}
	?>
</table>
</div>	
</div>
</div>
</body>
</html>