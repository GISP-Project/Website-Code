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
    <title>Catalogo Premi - QUICKUEUE</title>
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
                echo "<h2>Catalogo premi</h2>";			

                $sql = "SELECT * FROM tb_catalogo_premi";				
				$result = $conn->query($sql);

                if ($result->num_rows <= 0) {
					echo "<p class='error'>Errore, query fallita. </p>\n";
					echo "<a href='home.php'><button class='bottone'>Back</button></a>";
                } else {
					while ($row = $result->fetch_assoc()) {
						echo "<div class='riquadro'>";
						echo "<h4>Premio: ".$row['DescrizionePremio']."</h4>";
						echo "<h4>Punti: ".$row['PuntiRichiesti']."</h4>";
						echo "<a href='richiestaPremio.php?CodPremio=".$row['CodicePremio']."'><button class='bottone'>Richiedi premio</button></a>";
						echo "<br/></div><br/>";
					}
                }

                $conn->close();
            }

        } else {
			echo "<h2>Registrati o effettua il login per poter consultare i nostri premi su QUICKUEUE</h2>";
        }
        ?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
