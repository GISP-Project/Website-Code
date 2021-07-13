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
    <meta name="description" content="Accedi alla tua pagina personale per vedere i tuoi dati.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Profilo - QUICKUEUE</title>
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
				echo "	<p class='alcentro'>
							<label class='centrato'>E-mail: </label>
						</p>
						<p class='alcentro'>
							<input type='text' value='".$ente['emailEnte']."' readonly>
						</p>";
				echo "	<p class='alcentro'>
							<label>Ragione sociale: </label> 
						</p>
						<p class='alcentro'>
							<input type='text' value='".$ente['RagioneSociale']."' readonly>
						</p>";
				echo "	<p class='alcentro'>
							<label>Indirizzo: </label> 
						</p>
						<p class='alcentro'>
							<input type='text' value='".$ente['Indirizzo']."' readonly>
						</p>";
				echo "	<p class='alcentro'>
							<label>Città: </label> 
						</p>
						<p class='alcentro'>
							<input type='text' value='".$ente['Città']."' readonly>
						</p>";
				echo "	<p class='alcentro'>
							<label>Provincia: </label> 
						</p>
						<p class='alcentro'>
							<input type='text' value='".$ente['Provincia']."' readonly>
						</p>";
				echo "	<p class='alcentro'>
							<label>CAP: </label> 
						</p>
						<p class='alcentro'>
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
				
				echo "<form action='cambiaLimMaxPresenzeEnte.php' method='POST'>";
				echo "<div class='riquadro'>";
				echo "<h4>Modifica il limite massimo di ingressi:</h4>";
				echo "	<p class='alcentro'>
							<input type='text' id='limMaxPres' name='limMaxPres' value='".$ente['LimMaxPresenze']."'>
						</p>";
				echo "<input type='submit' value='Modifica'>";
				echo "<br/><br/></div></form><br/>";
				
				echo "<a href='home.php'><button class='bottone'>BACK</button></a>";
				
				
				$conn->close();
			}
		}
	  
	  
	  
	  


		?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
