<?
require 'include.php';

foreach($m->nlared->gpss->find(['imei'=>['$regex'=>'Lobus']]) as $doc){
	$doc['lat']=floatval($doc['lat']);
	$doc['lng']=floatval($doc['lng']);
	
	$gpss[]=$doc;
}
header('Content-Type: application/json');
echo json_encode($gpss);