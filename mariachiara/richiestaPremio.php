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
    <title>Conferma Premio - Quikueue</title>
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
				
				if(isset($_GET["CodPremio"])) {
					$sql = "SELECT * FROM tb_catalogo_premi WHERE CodicePremio = '".$_GET["CodPremio"]."'";				
					$result = $conn->query($sql);
					$row = $result->fetch_assoc();
					$puntiRichiesti = $row["PuntiRichiesti"];
					
					echo "<h2>Confermi che vuoi richiedere il premio?</h2>";
					echo "<h4>Premio: ".$row['DescrizionePremio']."</h4>";
					echo "<h4>Punti: ".$row['PuntiRichiesti']."</h4>";


					echo "<a href='confermaPremio.php?CodPremio=".$row['CodicePremio']."'><button class='bottone'>Conferma</button></a>";
					echo "<br/>";
					echo "<a href='listaPremi.php'><button class='bottone'>Back</button></a>";
				}
                
                $conn->close();
            }

        } else {
			echo "<h2>Registrati o effettua il login per poter consultare i nostri premi su QUIKUEUE</h2>";
        }
        ?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
