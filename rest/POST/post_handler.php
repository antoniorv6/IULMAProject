<?php
	include 'DataParser.php';
	include '../dbConnect.php';
	include '../responseSender.php';
	
	header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
	header("Content-Type: application/json");

	$response = null;
	switch($_POST["type"])
	{
		case "1":
			move_uploaded_file($_FILES["archivo"]["tmp_name"], "../../uploaded/".$_FILES["archivo"]["name"]);
			$fileHandler = new DataParser("../../uploaded/".$_FILES["archivo"]["name"]);
			$string = $fileHandler->convertToText();
			//Ya tenemos el string hecho, ahora llamamos a la función para sacar los datos
			ExtractData($fileHandler, $string);
		break;
		case "2":
			InsertDataInDB();
		break;
	}

	function ExtractData($parserObject, $content)
	{
		$type = 0;
		//Ver de que tipo es nuestro archivo
		/*DATOS DEFINITIVOS POR METER EN LA BD:
			Abreviatura -> LÍNEA 3
			Título de la columna particular -> LÍNEA 5

			Apellido 0
			Nombre 1
			Título general de la columna 2
			Nombre del periódico 3
			Lugar 4
			Fecha 5
			Página 6
			Columna 7 - puede ser nulo (comprobar tamaño de resultado)
			Tipo de publicación 8
			Idioma 9
			País 10 
		*/
		if($parserObject->type_of_doc() == 1) //Documento de word -> .docx
		{
			$lines = explode(chr(0x0D),$content); //Extraigo todas las líneas del texto
			$data = explode(',', $lines[1]);
			$abbreviation = explode(chr(0x0a), $lines[2]);
			$real_title = explode('.', $lines[3]);
			
			if(sizeof($data) == 11)
			{
				$arrayResponse = array(
					'ABBREVIATION' => $abbreviation[1],
					'TITLE' => $real_title[0],
					'SURNAME' => $data[0],
					'NAME' => $data[1],
					'GEN_TITLE' => $data[2],
					'SOURCE' => $data[3],
					'PLACE' => $data[4],
					'DATE' => $data[5],
					'PAGE' => $data[6],
					'COLUMN' => $data[7],
					'MEDIUM' => $data[8],
					'LANGUAGE' => $data[9],
					'COUNTRY' => $data[10],
					'PATH' => "uploaded/".$_FILES["archivo"]["name"],
					'CONTENT' => $content
				);
			}
			else
			{
				$arrayResponse = array(
					'ABBREVIATION' => $abbreviation[1],
					'TITLE' => $real_title[0],
					'SURNAME' => $data[0],
					'NAME' => $data[1],
					'GEN_TITLE' => $data[2],
					'SOURCE' => $data[3],
					'PLACE' => $data[4],
					'DATE' => $data[5],
					'PAGE' => $data[6],
					'COLUMN' => '-',
					'MEDIUM' => $data[7],
					'LANGUAGE' => $data[8],
					'COUNTRY' => $data[9],
					'PATH' => "uploaded/".$_FILES["archivo"]["name"],
					'CONTENT' => $content
				);
			}
			$type = 1;
		}
		else if($parserObject->type_of_doc() == 2)
		{
			$lines = explode(chr(0x0D),$content); //Extraigo todas las líneas del texto
			$data = explode(',', $lines[0]);
			if(sizeof($lines)>1)
			{
				$position = sizeof($data)-1;
				for($counter = 1 ; $counter < sizeof($lines); $counter++) //Mientras hayan lineas separadas por retorno de carros
				{
					$dataforincluding = explode(",", $lines[$counter]);
					foreach($dataforincluding as $mustinclude)
					{
						$data[$position] = $mustinclude;
						$position++;
					}
				}
			}
			//SOLUCIÓN MUY CUTRE PARA LOS PDF, MUCHO OJO QUE SI NO RESPETAN EL FORMATO NO FUNCIONA BIEN
			$real_title = explode(chr(0x0a), $data[12]);
			$abbreviation = explode(chr(0x0a), $data[11]);

			if(sizeof($data) == 81)
			{
				$arrayResponse = array(
					'ABBREVIATION' => $abbreviation[1],
					'TITLE' => $real_title[1],
					'SURNAME' => $data[0],
					'NAME' => $data[1],
					'GEN_TITLE' => $data[2],
					'SOURCE' => $data[3],
					'PLACE' => $data[4],
					'DATE' => $data[5],
					'PAGE' => $data[6],
					'COLUMN' => $data[7],
					'MEDIUM' => $data[8],
					'LANGUAGE' => $data[9],
					'COUNTRY' => $data[10],
					'PATH' => "uploaded/".$_FILES["archivo"]["name"],
					'CONTENT' => $content
				);
			}
			else
			{
				$arrayResponse = array(
					'ABBREVIATION' => $abbreviation[1],
					'TITLE' => $real_title[1],
					'SURNAME' => $data[0],
					'NAME' => $data[1],
					'GEN_TITLE' => $data[2],
					'SOURCE' => $data[3],
					'PLACE' => $data[4],
					'DATE' => $data[5],
					'PAGE' => $data[6],
					'COLUMN' => '-',
					'MEDIUM' => $data[7],
					'LANGUAGE' => $data[8],
					'COUNTRY' => $data[9],
					'PATH' => "uploaded/".$_FILES["archivo"]["name"],
					'CONTENT' => $content
				);
			}
			$type = 1;
		}
		else
		{
			$arrayResponse = array(
				'ERROR' => "Error, document extension not supported"
			);
		}
		
		SendResponse($type, $arrayResponse);
	}

	function InsertDataInDB()
	{
		$response = null;
		$dbConnection = connectToDB();
		//Conectados a la base de datos
		//Saneamos las variables que insertamos en la query y las parseamos
		$abbreviation = '"'.$_POST['abbreviation'].'"';
		$surname = '"'.$_POST['surname'].'"';
		$name = '"'.$_POST['name'].'"';
		$title = '"'.$_POST['title'].'"';
		$gen_title = '"'.$_POST['gen_title'].'"';
		$source = '"'.$_POST['source'].'"';
		$place = '"'.$_POST['place'].'"';
		$date = '"'.$_POST['date'].'"';
		$col = '"'.$_POST['column'].'"';
		$medium = '"'.$_POST['medium'].'"';
		$language = '"'.$_POST['language'].'"';
		$country = '"'.$_POST['country'].'"';
		$user = '"'.$_POST['user'].'"';
		$path = '"'.$_POST['filepath'].'"';
		//Fin del saneamiento
		$query = "INSERT INTO `column` (Abbreviation,Author_surname, Author_Name, Title, gen_title, Place, Dateofcreation, Col, Source, Medium, Language_written, Country, First_insert, Last_insert, Filepath) VALUES ($abbreviation,$surname, $name, $title, $gen_title, $place, $date, $col, $source, $medium, $language, $country, $user, $user, $path)";
		//Query escrita, ahora escribimos en la base de datos

		if(!($result = @mysqli_query($dbConnection, $query))) 
        {
			$response = array(
				'RESULT' => 'ERROR',
				'MESSAGE' => 'Ha habido un error realizando su petición',
				'DEBUGMESSAGE' => mysqli_error($dbConnection)
			);
			
			SendResponse(0, $response);
		}
		
		$secondquery = "SELECT ID FROM `column` WHERE Abbreviation = $abbreviation";
		if(!($secondresult = @mysqli_query($dbConnection, $secondquery))) 
        {
			$response = array(
				'RESULT' => 'ERROR',
				'MESSAGE' => 'Ha habido un problema encontrando tu ID',
				'DEBUGMESSAGE' => mysqli_error($dbConnection)
			);
			
			SendResponse(0, $response);
		}

		$data=mysqli_fetch_assoc($secondresult);

		//Aquí toca meter los datos adicionales
		if(SendContent($dbConnection,$data['ID'], $_POST['content']))
		{	
			$insert = false;
			$idtoinsert = $data['ID'];
			$finalquery = "INSERT INTO additionaldata (article, profession, style, lpolicy, dimention, loans, neologism, wordformation, etimology) VALUES ($idtoinsert, ";
			$finalquery = $finalquery . getAditionalContent();
			
			
			if(!($result = @mysqli_query($dbConnection, $finalquery))) 
        	{
				$response = array(
					'RESULT' => 'ERROR',
					'MESSAGE' => 'Ha habido un problema metiendo los datos adicionales',
					'DEBUGMESSAGE' => mysqli_error($dbConnection));
				
				SendResponse(0, $response);	
			}

		$response = array(
				'RESULT' => 'OK',
				'MESSAGE' => $finalquery
			);
			
			SendResponse(1, $response);
		}
	}

	function getAditionalContent()
	{
		$finalquery = "";
		if(!isset($_POST['profession']))
		{
			$finalquery = $finalquery. "'-',";
		}
		else
		{
			$finalquery = $finalquery . extractCheckedData($_POST['profession']). ",";
		}
		
		if(!isset($_POST['style']))
		{
			$finalquery = $finalquery. "'-',";
		}
		else
		{
			$finalquery = $finalquery . extractCheckedData($_POST['style']). ",";
		}

		$finalquery = $finalquery."'".$_POST['policy']."'".",";

		if(!isset($_POST['dimention']))
		{
			$finalquery = $finalquery. "'-',";
		}
		else
		{
			$finalquery = $finalquery . extractCheckedData($_POST['dimention']). ",";
		}

		if(!isset($_POST['loans']))
		{
			$finalquery = $finalquery. "'-',";
		}
		else
		{
			$finalquery = $finalquery . extractCheckedData($_POST['loans']). ",";
		}

		$finalquery = $finalquery."'".$_POST['neologism']."'".",";

		if(!isset($_POST['wordformation']))
		{
			$finalquery = $finalquery. "'-',";
		}
		else
		{
			$finalquery = $finalquery . extractCheckedData($_POST['wordformation']). ",";
		}

		$finalquery = $finalquery."'".$_POST['etimology']."'";

		$finalquery = $finalquery.")";

		return $finalquery;
	}

	function extractCheckedData($array)
	{
		$dataextracted = '"';
		$size = count($array);
		$firstone = true;

			for($i = 0 ; $i < $size; $i++)
			{
				if(isset($array[$i]))
				{
					if($firstone)
					{
						if($i == $size-1)
							$dataextracted = $dataextracted.$array[$i];
						else
							$dataextracted = $dataextracted.$array[$i].",";
						
						$firstone = false;
					}
					else
					{
						if($i == $size-1)
							$dataextracted = $dataextracted.$array[$i];
						else
							$dataextracted = $dataextracted.$array[$i].",";
					}
				}
			}
			
			$dataextracted = $dataextracted. '"';
			return $dataextracted;
	}

	function SendContent($dbConnection, $id, $content)
	{
		$contenttoDB = '"'.mysqli_real_escape_string($dbConnection,$content).'"';
		$query = "INSERT INTO content (article, textcontent) VALUES ($id, $contenttoDB)";

		if(!($result = @mysqli_query($dbConnection, $query))) 
        {
			$response = array(
				'RESULT' => 'ERROR',
				'MESSAGE' => 'Ha habido un problema metiendo el contenido',
				'DEBUGMESSAGE' => mysqli_error($dbConnection)
			);

			echo mysqli_error($dbConnection);
			
			SendResponse(0, $response);
			return false;
		}

		return true;

	}

?>