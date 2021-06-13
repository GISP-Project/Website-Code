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
    <meta name="description" content="Accedi alla tua pagina personale per vedere i tuoi dati.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Profilo - QUIKUEUE</title>
    <link rel="stylesheet" href="stile.css">

  </head>
  <body>
    <?php require 'header.php'; ?>
    <main class="row">

		<?php
		$username = "";
		$password = "";
		if (!isset($_SESSION['user'])) {
			echo "Hai effettuato il login, non puoi accedere alla tua pagina.";
		} else {
			$conn = new mysqli("localhost", "root_utenti", "root_utenti", "mysql");
			if ($conn->connect_error) {
			  echo "<p class='error'>Siamo spiacenti ma c'è stato un errore connessione al database: ".$conn->connect_error."</p>\n";
			}else{
				$sql = "SELECT * FROM tb_ambiente WHERE emailEnte='".$_SESSION['user']."'";
				$result = $conn->query($sql);
				$ente = $result->fetch_assoc();
				
				echo "<h2>Il tuo profilo</h2>";
						
				echo "<div class='riquadro'>";
				echo "	<p class='centrato'>
							<label class='centrato'>E-mail: </label> 
							<input class='centrato' type='text' value='".$ente['emailEnte']."' readonly>
						</p>";
				echo "	<p class='centrato'>
							<label>Ragione sociale: </label> 
							<input type='text' value='".$ente['RagioneSociale']."' readonly>
						</p>";
				echo "	<p class='centrato'>
							<label>Indirizzo: </label> 
							<input type='text' value='".$ente['Indirizzo']."' readonly>
						</p>";
				echo "	<p class='centrato'>
							<label>Città: </label> 
							<input type='text' value='".$ente['Città']."' readonly>
						</p>";
				echo "	<p class='centrato'>
							<label>Provincia: </label> 
							<input type='text' value='".$ente['Provincia']."' readonly>
						</p>";
				echo "	<p class='centrato'>
							<label>CAP: </label> 
							<input type='text' value='".$ente['CAP']."' readonly>
						</p>";
				echo "<br/></div><br/>";
				
				echo "<div class='riquadro'>";
				if ($ente['prenotazione'] == "Y") {
					echo "<h4>Annullare la possibilità di prenotare l'ingresso?</h4>";
					echo "<a href='cambiaStatoPrenotEnte.php?statoPrenotazione=N'><button class='bottone'>ANNULLA</button></a>";
				} else {
					echo "<h4>Vuoi permettere ai clienti di prenotare l'ingresso?</h4>";
					echo "<a href='cambiaStatoPrenotEnte.php?statoPrenotazione=Y'><button class='bottone'>ATTIVA</button></a>";
				}
				
				echo "<br/></div><br/>";
				
				echo "<a href='home.php'><button class='bottone'>BACK</button></a>";
				
				
				$conn->close();
			}
		}
	  
	  
	  
	  


		?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
