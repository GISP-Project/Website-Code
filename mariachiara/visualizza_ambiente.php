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
    <title>Dettagli ambiente - QUIKUEUE</title>
    <link rel="stylesheet" href="stile.css">
  </head>
  <body>
    <!-- <?php require 'header.php'; ?> -->
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
						echo "<h2>".$row['RagioneSociale']."</h2>";
						echo "<a href='preferiti.php?IdPref=".$_SESSION['ID_AMBIENTE']."'><button class='bottone'>Aggiungi a Preferiti</button></a>";
						echo "<table class='row'>";
						echo "
								<tr><th class='col-6'>Affollamento Real Time:</th><td class='col-6'>".$row['PresenzeRealTime']."</td></tr>
								<tr><th class='col-6'>Numero massimo utenti:</th><td class='col-6'>".$row['LimMaxPresenze']."</td></tr>
								<tr><th class='col-6'>Indirizzo:</th><td class='col-6'>".$row['Indirizzo']."</td></tr>
								<tr><th class='col-6'>Città:</th><td class='col-6'>".$row['Città']."</td></tr>
								<tr><th class='col-6'>Provincia:</th><td class='col-6'>".$row['Provincia']."</td></tr>
								<tr><th class='col-6'>CAP:</th><td class='col-6'>".$row['CAP']."</td></tr>
								<tr><th class='col-6'>Tipo Ambiente:</th><td class='col-6'>".$row['TipoAmbiente']."</td></tr>";
								
						echo "</table>";
					}
					
					echo "<div class='centered'>".$row['GoogleMap']."</div>";
					echo "<br/><a href='ambienti.php'><button class='bottone'>Back</button></a>";
					
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
    <!-- <?php require 'footer.php'; ?> -->
  </body>
</html>
