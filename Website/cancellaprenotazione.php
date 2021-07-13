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
    <meta name="author" content="Team Quickueue">
    <meta name="description" content="Prenotazioni QUICKUEUE.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Conferma Premio - QUICKUEUE</title>
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
            else {
				if(isset($_POST["idPrenotazione"])) {
					$sql = "SELECT * FROM tb_prenotazione 
							WHERE emailUtente ='".$_SESSION["user"]."' 
							AND statoPrenotazione = 'ATTIVA'
							AND idPrenotazione = '".$_POST["idPrenotazione"]."'";				
					$result = $conn->query($sql);
					
					if ($result->num_rows <= 0) {
						echo "<p class='error'>Errore, impossibile risalire alla prenotazione ".$_POST["idPrenotazione"].". </p>\n";
					} else {
						
						$row = $result->fetch_assoc();
						$dataoraPrenotazione = intval($row["dataoraPrenotazione"]);
						$intDtPren = intval($dataoraPrenotazione);
						$dataOdierna = new DateTime();
						$dataOdierna = $dataOdierna->format('YmdHi');
						$intDtOdierna = intval($dataOdierna);
						$diffDate = $intDtPren - $intDtOdierna;
						
						//1 day = 10000
						if ($diffDate <= 10000) {
							echo "<h4>Code Prenotazione:</h4>";
							echo "<h2>".$_POST["idPrenotazione"]."</h2>";
							echo "<p class='error'>E' possibile cancellare la prenotazione non oltre le 24h precedenti alla prenotazione stessa.</p>";
						} else {
							// sql to update a record
							$sql = "UPDATE tb_prenotazione 
									SET statoPrenotazione = 'CANCELLATA_UTENTE' 
									WHERE emailUtente = '".$_SESSION["user"]."'
									AND idPrenotazione = '".$_POST["idPrenotazione"]."'";

							if ($conn->query($sql) === TRUE) {
								echo "<h4>Code Prenotazione:</h4>";
								echo "<h2>".$_POST["idPrenotazione"]."</h2>";
								echo "<h4>e' stata annullata.</h4>";
											
							} else {
								echo "<p class='error'>Siamo spiacenti ma c'è stato un errore connessione al database: ".$conn->connect_error."</p>\n";
							}
						}
					
					}

				} else {
					echo "<p class='error'>Nessuna prenotazione da annullare.</p>";
				}

			}
			
			echo "<a href='listaPrenotazioniUtente.php'><button class='bottone'>Back</button></a>";
			$conn->close();

        } else {
			echo "<h2>Registrati o effettua il login per poter utilizzare i servizi di QUICKUEUE</h2>";
        }
		
        ?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
