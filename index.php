<?php
ini_set('display_errors',1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); //toon alle fouten behalve notices en warnings	
setlocale(LC_MONETARY, 'nl_NL.UTF-8');	
setlocale(LC_TIME, 'nl_NL.UTF-8');
date_default_timezone_set('Europe/Amsterdam');
@include_once('dev/db.php');
$groep="ao";
$groepdispl="AO";
if(isset($_GET['groep']))
	$groep=$_GET['groep'];
if($groep=="beh")
	$groepdispl="Beheer";

$vakid=1;
if(isset($_GET['vakid']))
	$vakid=$_GET['vakid'];

$dbconnect = new dbconnection();
$sql="SELECT * FROM lessen LEFT OUTER JOIN opgaven ON les_id = opg_les_id WHERE les_vakid=:vakid ORDER BY les_".$groep."datum";
$query = $dbconnect -> prepare($sql);
$query->bindParam(":vakid", $vakid);
$query ->execute();
$lessen = $query -> fetchAll(PDO::FETCH_ASSOC);
	
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
 </head>
<body onLoad="openSubmenu(1,1)">
<div class="mai-wrapper">

<div class="container">	
	
<h1>Wiskundeplanning <?= $groepdispl ?>-groepen (OSD)	</h1>
<div class="table-responsive-xl">
<table class="table table-hover">
	<thead class="thead-dark">
    <tr>
      <th scope="col" class="text-right">#</th>
      <th scope="col">Datum</th>
      <th scope="col">Docent</th>
      <th scope="col">Aan de slag</th>
      <th scope="col">Doel</th>
    </tr>
  </thead>
<?php
	$vorigelesnr=0;
	$i=0;
	foreach($lessen as $les)
	{
		if($i==0)
		{
			$lesnr=$les['les_'.$groep.'lesnr'];
			$datum=strftime('%a %e %h' , strtotime($les['les_'.$groep.'datum']));
			$methode=nl2br($les['les_methode']);
			$aandeslag="<a href='".$les['opg_url']."' target='_blank'>".$les['opg_opgaven']."</a>";
			$doel=nl2br($les['les_doel']);
			$vorigelesnr=$lesnr;
		}
		else
		{
			if($les['les_'.$groep.'lesnr']==$vorigelesnr)
			{
				$aandeslag.="<br><a href='".$les['opg_url']."' target='_blank'>".$les['opg_opgaven']."</a>";
			}
			else
			{
				echo "<tr>";
				echo "<td class='text-right' width='75'>Les ".$lesnr."</td>";
				echo "<td width='100'>".$datum."</td>";
				echo "<td width='250'>".$methode."</td>";
				echo "<td width='250'>".$aandeslag."</td>";
				echo "<td>".$doel."</td></tr>";
				$lesnr=$les['les_'.$groep.'lesnr'];
				$datum=strftime('%a %e %h' , strtotime($les['les_'.$groep.'datum']));
				$methode=nl2br($les['les_methode']);
				$aandeslag="<a href='".$les['opg_url']."' target='_blank'>".$les['opg_opgaven']."</a>";
				$doel=nl2br($les['les_doel']);
				$vorigelesnr=$lesnr;
			}
		}
		$i++;	
	}
	echo "<tr>";
	echo "<td class='text-right' width='75'>Les ".$lesnr."</td>";
	echo "<td width='100'>".$datum."</td>";
	echo "<td width='250'>".$methode."</td>";
	echo "<td width='250'>".$aandeslag."</td>";
	echo "<td>".$doel."</td></tr>";
	?>
</table>
</div>	
</div>
</div>
</body>
</html>