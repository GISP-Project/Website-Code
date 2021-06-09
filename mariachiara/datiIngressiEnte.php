<?php
    $session = true;

if( session_status() === PHP_SESSION_DISABLED  )
    $session = false;
elseif( session_status() !== PHP_SESSION_ACTIVE )
{
	session_start();
}
?>
<!DOCTYPE html>
<html lang="it" >
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=yes">
    <meta name="author" content="Mariachiara Mastrangelo">
    <meta name="description" content="Servizio per dati real-time affollamento ambienti.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Dati Ingressi - Quikueue</title>
    <link rel="stylesheet" href="stile.css">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main class="row">
	
		<?php
			if (isset($_SESSION["user"])) {
				$conn = new mysqli("localhost", "root_utenti", "root_utenti", "mysql");
				if ($conn->connect_error)
					echo "<p class='error'>Siamo spiacenti ma c'è stato un errore connessione al database: ".$conn->connect_error."</p>\n";
				else{
					echo "<h2>".$_SESSION['RagioneSocialeEnte']."</h2>";
					echo "<h2>Dati affollamento real-time</h2>";
					
					$sql = "SELECT * FROM tb_Ambiente WHERE emailEnte='".$_SESSION["user"]."'";
					$result = $conn->query($sql);

					if ($result->num_rows <= 0) {
						echo "<p class='error'>Errore nell'estrazione degli ambienti associati all'utente ".$_SESSION["user"].". </p>\n";
						echo "<a href='home.php'><button class='bottone'>Back</button></a>";
					} else {	

						$url = "https://api.thingspeak.com/channels/1403429/feeds.json?api_key=K82OA225Q0TS4EK5&results=1";
			
						//Se hai un URL e il tuo php lo supporta, puoi semplicemente chiamare file_get_contents:
						$data = file_get_contents($url);
						//se $ response è JSON, utilizzare json_decode per trasformarlo in array php:
						$response = json_decode($data);
						
						//echo "<div class='centrato'>";
						//print_r($response);
						//echo "</div>";
						
						echo "<div class='centrato'>";
						//print_r($response->channel->id);
						//print_r($response->feeds[0]->field1);
						$tmpDataora = $response->feeds[0]->created_at;
						$dataoraAggiornamento = substr($tmpDataora, 8, 2)."/".
												substr($tmpDataora, 5, 2)."/".
												substr($tmpDataora, 0, 4)." ".
												substr($tmpDataora, 11, 5);
						echo "<h4>Ultimo aggiornamento: ".$dataoraAggiornamento."</h4>";
						echo "<h4>Numero utenti presenti: ".$response->feeds[0]->field1."</h4>";
						echo "</div>";
						
						echo '
						<div class="centrato">		
							<iframe width="450" height="260" style="border: 1px solid #cccccc;" 
							src="https://thingspeak.com/channels/1403429/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15">
							</iframe>
						</div>
						';
						
					}


					$conn->close();
				}

			} else {
				echo "<h2>Registrati o effettua il login per poter consultare le tue prenotazioni su QUIKUEUE</h2>";
			}
		
		
		?>
		
		<script>
			redirectTime = "30000";
			redirectURL = "datiIngressiEnte.php";
			setTimeout("location.href = redirectURL;",redirectTime);
		</script>
		
		
		
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
