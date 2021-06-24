<?php
	$conn = new mysqli("localhost", "root_utenti", "root_utenti", "mysql");
	
	$sql = "SELECT * FROM tb_Ambiente WHERE 1=1";
	$result = $conn->query($sql);
	while ($ambiente = $result->fetch_assoc()) {
		if (isset($ambiente['url_thingspeak'])) {
			echo "URL: ".$ambiente['url_thingspeak']."\n";
			
			//Se hai un URL e il tuo php lo supporta, puoi semplicemente chiamare file_get_contents:
			$data = file_get_contents($ambiente["url_thingspeak"]);
			//se $ response è JSON, utilizzare json_decode per trasformarlo in array php:
			$response = json_decode($data);
				
			$timestamp = date("YmdHis");
			$PresenzeRealTime = $response->feeds[0]->field1;
			
			$sql = "INSERT INTO tb_storicoambiente (ID_Ambiente, Dataora_Inserimento, Presenze) 
					VALUES ('".$ambiente['ID']."', '".$timestamp."', ".$PresenzeRealTime.")";
			if ($conn->query($sql) === TRUE) {
				echo "URL: Inserimento riuscito\n";
			} else {
				echo "URL: Inserimento fallito\n";
			}
			
		}
	}
 ?>