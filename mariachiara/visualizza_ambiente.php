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
    <meta name="description" content="Pagina di dettaglio dell'ambiente selezionato.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Dettagli ambiente - QUICKUEUE</title>
    <link rel="stylesheet" href="stile.css">
  </head>
  <body>
    <main class="row">
        <?php
        if(!$session){
            echo "<p class='error'>Le sessioni sono disabilitate!</p>";
        }else{
			if (isset($_SESSION["user"])) {
				$conn = new mysqli("localhost", "root_utenti", "root_utenti", "mysql");
				if ($conn->connect_error)
					echo "<p class='error'>Siamo spiacenti ma c'è stato un errore connessione al database: ".$conn->connect_error."</p>\n";
				else{
					if(isset($_REQUEST['id'])){
						$_SESSION['ID_AMBIENTE'] = substr($_REQUEST['id'],2);
						$_SESSION['ID_AMB_PREF'] = $_SESSION['ID_AMBIENTE'];
					}

					$sql = "SELECT * FROM tb_Ambiente WHERE ID = '".$_SESSION['ID_AMBIENTE']."'";
					$result = $conn->query($sql);
					
					if ($result->num_rows <= 0) {
						echo "<p class='error'>Errore, query fallita. Non trovato l'elemento con ID: ".$_SESSION['ID_AMBIENTE']."</p>\n";
					} else {
						$row = $result->fetch_assoc();
						$PresenzeRealTime = $row['PresenzeRealTime'];
						
						if (isset($row['url_thingspeak'])) {							
							//Se hai un URL e il tuo php lo supporta, puoi semplicemente chiamare file_get_contents:
							$data = file_get_contents($row["url_thingspeak"]);
							//se $ response è JSON, utilizzare json_decode per trasformarlo in array php:
							$response = json_decode($data);
								
							$PresenzeRealTime = $response->feeds[0]->field1;
							
							$sql = "UPDATE tb_Ambiente SET PresenzeRealTime = '".$response->feeds[0]->field1."' WHERE ID = '".$_SESSION['ID_AMBIENTE']."'";
							if ($conn->query($sql) === TRUE) {
							} else {
							}
						}
						
						
						echo "<h2>".$row['RagioneSociale']."</h2>";
						echo "<p class='alcentro'>".$row['Indirizzo']."</p>";
						echo "<p class='alcentro'>".$row['Città']." - ".$row['Provincia']." - ".$row['CAP']."</p>";
						echo "<p class='alcentro'>".$row['TipoAmbiente']."</p>";
						echo "<a href='preferiti.php?IdPref=".$_SESSION['ID_AMBIENTE']."'><button class='bottone'>Aggiungi a Preferiti</button></a>";
						if ($row['prenotazione'] == "Y") {
							echo "<br/><a href='prenotazione.php?IdPren=".$_SESSION['ID_AMBIENTE']."&RagSocPren=".$row['RagioneSociale']."'>
								<button class='bottone'>Prenota ingresso</button></a>";
						} else {
							echo "<p class='error'>L'ente non ha dato l'autorizzazione a prenotare l'ingresso.</p>";
						}
						
						echo "<br/><div class='riquadro'>";
						echo "<h4>Affollamento Real Time: ".$PresenzeRealTime."</h4>";
						echo "<h4>Numero massimo utenti: ".$row['LimMaxPresenze']."</h4>";
						echo "<div class='alcentro'>".$row['GoogleMap']."</div>";
						echo "<br/></div><br/>";
					}
					
					echo "<br/><a href='gestione_ambiente.php'><button class='bottone'>Back</button></a>";
					
					/*echo '
						<script>
							redirectTime = "5000";
							redirectURL = "gestione_ambiente.php";
							setTimeout("location.href = redirectURL;",redirectTime);
						</script>';*/
					
				}
			}
        }
        ?>
    </main>
  </body>
</html>
