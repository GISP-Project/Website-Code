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
    <meta name="description" content="Prenotazioni QUIKUEUE.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Lista prenotazioni - Quikueue</title>
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
				echo "<h2>Prenotazioni ricevute</h2>";
				
				$sql = "SELECT * FROM tb_prenotazione, tb_Ambiente 
						WHERE tb_prenotazione.idAmbiente = tb_Ambiente.ID
						AND tb_Ambiente.emailEnte='".$_SESSION["user"]."' 
						AND statoPrenotazione = 'ATTIVA'";
				$result = $conn->query($sql);

                if ($result->num_rows <= 0) {
					echo "<p class='error'>Non ci sono prenotazioni attive. </p>\n";
					echo "<a href='home.php'><button class='bottone'>Back</button></a>";
                } else {
					echo "<h4>Ci sono: ".$result->num_rows." prenotazione/i attiva/e.</h4>";
					echo "<table class='row'> 
							<form action='chiusuraPrenotazioneEnte.php' method='POST'>";
							
					echo "	<thead class='hide'>
								<th>ID</th>
								<th>Cliente</th>
								<th>Data/ora</th>
								<th>Stato</th>
								<th>Chiudi prenotazione</th>
							</thead>
							<tbody>";
							
					while ($row = $result->fetch_assoc()) {
						
						//<td><button type='submit' name='id' value='V_".$row['ID']."'>".$row['ID']."</button></td>
						$dataoraPrenotazione = substr($row['dataoraPrenotazione'], 6, 2)."/".
												substr($row['dataoraPrenotazione'], 4, 2)."/".
												substr($row['dataoraPrenotazione'], 0, 4)." ".
												substr($row['dataoraPrenotazione'], 8, 2).":".
												substr($row['dataoraPrenotazione'], 10, 2)." ";
						echo "
							<thead class='show'><th>Ragione Sociale</th></thead>
							<tr>
								<td>".$row['idPrenotazione']."</td>
								<td>".$row['emailUtente']."</td>
								<td>".$dataoraPrenotazione."</td>
								<td>".$row['statoPrenotazione']."</td>
								<td><button type='submit' name='idPrenotazione' value='".$row['idPrenotazione']."'>CHIUDI</button></td>
							</tr>";
					}
					echo "</tbody>
							</form>
							</table>";
                }


                $conn->close();
            }

        } else {
			echo "<h2>Registrati o effettua il login per poter consultare le tue prenotazioni su QUIKUEUE</h2>";
        }
        ?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
