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
            else{
				echo "<h2>Cambio stato prenotazione</h2>";
				
				if(isset($_POST["limMaxPres"])) {
					
					$sql = "UPDATE tb_ambiente SET LimMaxPresenze = '".$_POST["limMaxPres"]."' WHERE emailEnte = '".$_SESSION["user"]."'";
					if ($conn->query($sql) === TRUE) {
						echo "<h4>Limite Massimo di Presenze cambiato.</h4>";
						echo "<h4>".$_POST["limMaxPres"]."</h4>";
					} else {
						echo "<p class='error'>Errore, non e' stato possibile cambiare il limite massimo di presenze. Errore: ".$conn->error."</p>\n";
					}
					
				} else {
					echo "<p class='error'>Non e' stato indicato il limite massimo di presenze per aggiornare il db. Torna al profilo.</p>\n";
				}
                
                $conn->close();
            }

        } else {
			echo "<h2>Registrati o effettua il login su QUICKUEUE</h2>";
        }
		
		echo "<a href='profiloEnte.php'><button class='bottone'>Back</button></a>";
        ?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
