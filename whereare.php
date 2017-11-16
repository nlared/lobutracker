<?
require 'include.php';
header("Content-type:application/json");
$gpss=[];




use Location\Coordinate;
use Location\Polygon;

$geofence = new Polygon();
$cerca=$m->nlared->geocercas->findOne(['_id' => new MongoDB\BSON\ObjectID("59af88ea8046292c13505fa2")]);
$data=$cerca->geometry->coordinates[0];
foreach($data as $coords){
	$geofence->addPoint(new Coordinate(floatval($coords[1]),floatval($coords[0])));
}

foreach($m->nlared->gpss->find([
	'imei'=>['$regex'=>'Lobus'],
	'datetime'=>['$gte'=> date('Y-m-d H:i',strtotime('-1 minutes'))]
	]) as $doc){
	$insidePoint = new Coordinate($doc['lat'], $doc['lng']);
	if($geofence->contains($insidePoint)){
		$gpss[]=[
			'id'=>(string)$doc['_id'],
			'imei'=>$doc['imei'],
			'lat'=>$doc['lat'],
			'lng'=>$doc['lng']
		];
	}
}
echo json_encode($gpss);