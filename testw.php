<?php
$developermode=true;
require 'include.php';
set_time_limit(0);
//error_reporting(0);

//require '/var/www/facturacion.nlared.com/Comprobantes/pacs/facturadorelectronico.com/lib/nusoap.php';
//$client = new nusoap_client('http://www.decawebservice-01.com/webservice/pwd5/index.php?wsdl', 'soap');
//$client->soap_defencoding = "UTF-8";
//$client->decode_utf8 = false;
$mynamespace='pwd5';
$client = new SoapClient('http://www.decawebservice-01.com/webservice/pwd5/index.php?wsdl');

$params = array(
    'company'=>'tucsa',
	'user'=>'Lobus',
	'password'=> 'Lobus',
	'timeZone'=> -5,
	'language'=> 'es'

);

$ola=0;
do{
	try{
		$resultado = $client->__soapCall('getCurrentPositions', $params);//, $mynamespace);
		$ahora=date('Y-m-d H:i:s');
		$dentro=[];
		//print_r($resultado);
		foreach($resultado as $gpsss){
			$gps=(array)$gpsss;
			$m->nlared->gpss->updateOne(['imei'=>'Lobus'.$gps['idGPS']],['$set'=>[
				'lat'=>$gps['lat'],
				'lng'=>$gps['lng'],
				'velocidad'=>floatval($gps['speed']),
				'dentro'=>$dentro,
				'datetime'=>$ahora,
				]],['upsert'=>true]);
			
		}
	}catch(Exception $e){
		
	}
	
	sleep(10);
	
	$ola++;
}while(true);


//header("Content-type:application/json");
//echo json_encode($resultado);
?>