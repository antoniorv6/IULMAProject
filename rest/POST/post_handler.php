<?php
	include 'DataParser.php';
	
	header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
	header("Content-Type: application/json");

	$response = null;
	switch($_POST["type"])
	{
		case '1':
			move_uploaded_file($_FILES["archivo"]["tmp_name"], "../../uploaded/".$_FILES["archivo"]["name"]);
			$fileHandler = new DataParser("../../uploaded/".$_FILES["archivo"]["name"]);
			$string = $fileHandler->convertToText();
			//Ya tenemos el string hecho, ahora llamamos a la función para sacar los datos
			$responseBody = ExtractData($string);
			SendResponse($responseBody);
		break;
	}

	function ExtractData($content)
	{
		$lines = explode(chr(0x0D),$content); //Extraigo todas las líneas del texto
		$data = explode(',', $lines[1]);

		$arrayResponse = array(
			'SURNAME' => $data[0],
			'NAME' => $data[1],
			'TITLE' => $data[2],
			'SOURCE' => $data[3],
			'PLACE' => $data[4],
			'DATE' => $data[5],
			'PAGE' => $data[6],
			'COLUMN' => $data[7],
			'MEDIUM' => $data[8],
			'LANGUAGE' => $data[9],
			'COUNTRY' => $data[10]
		);
		
		return $arrayResponse;
	}

	function SendResponse($body)
	{
		http_response_code(200);
		$response = array('RESPONSE_CODE' => 200, 'RESPONSE_TYPE'=>'OK');
		$response['BODY'] = $body; 
		print json_encode($response);
	}
?>