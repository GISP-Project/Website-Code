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
    <meta name="description" content="Prenotazioni QUICKUEUE.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Lista prenotazioni - QUICKUEUE</title>
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
                echo "<h2>Le tue prenotazioni</h2>";			

                $sql = "SELECT * FROM tb_prenotazione 
						WHERE emailUtente ='".$_SESSION["user"]."' AND statoPrenotazione = 'ATTIVA'
						ORDER BY dataoraPrenotazione";				
				$result = $conn->query($sql);

                if ($result->num_rows <= 0) {
					echo "<p class='error'>Non sono presenti prenotazioni attive. </p>\n";
					echo "<a href='home.php'><button class='bottone'>Back</button></a>";
                } else {
					echo "<h4>Hai: ".$result->num_rows." prenotazioni attive.</h4>";
					echo "<form action='cancellaprenotazione.php' method='POST'>";
					while ($row = $result->fetch_assoc()) {
						$dataoraPrenotazione = substr($row['dataoraPrenotazione'], 6, 2)."/".
												substr($row['dataoraPrenotazione'], 4, 2)."/".
												substr($row['dataoraPrenotazione'], 0, 4)." ".
												substr($row['dataoraPrenotazione'], 8, 2).":".
												substr($row['dataoraPrenotazione'], 10, 2)." ";
						echo "<div class='riquadro'>";
						echo "<p class='alcentro'>".$row['idPrenotazione']."</p>
							<p class='alcentro'>".$row['RagSocAmbiente']."</p>
							<p class='alcentro'>".$dataoraPrenotazione."</p>";
						echo "<button class='bottone' type='submit' name='idPrenotazione' value='".$row['idPrenotazione']."'>DELETE</button>";
						echo "<br/></div><br/>";
					}
					echo "</form>";
					
                }


                $conn->close();
            }

        } else {
			echo "<h2>Registrati o effettua il login per poter consultare le tue prenotazioni su QUICKUEUE</h2>";
        }
        ?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
