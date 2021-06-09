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
                echo "<h2>Chiusura prenotazione</h2>";	

				$sql = "UPDATE tb_prenotazione SET statoPrenotazione = 'CHIUSA' WHERE idPrenotazione = '".$_POST['idPrenotazione']."'";
				if ($conn->query($sql) === TRUE) {
					echo "<h4>La prenotazione avente ID:</h4>";
					echo "<h2>".$_POST['idPrenotazione']."</h2>";
					echo "<h4>e' stata correttamente chiusa.</h4>";
				} else {
					echo "<p class='error'>Errore, non e' stato possibile chiudere la prenotazione avente ID: ".$_POST['idPrenotazione'].". Errore: ".$conn->error."</p>\n";
				}
				
				echo "<a href='listaPrenotazioniEnte.php'><button class='bottone'>Back</button></a>";

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
