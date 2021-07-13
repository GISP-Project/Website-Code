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
    <meta name="description" content="Elenco degli ambienti preferiti.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Preferiti - Quickueue</title>
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
                echo "<h2>I tuoi ambienti preferiti</h2>";
				
				if (isset($_GET['IdPref'])) {
					if ($_GET['IdPref'] != "") {
						$IdPref=$_GET['IdPref'];
						$sql = "SELECT * FROM tb_utente WHERE email = '".$_SESSION["user"]."'";
						$result = $conn->query($sql);
						
						$pref = $result->fetch_assoc();
						$prefNewLst = $pref['preferiti'];
						$pos = strpos($prefNewLst, "#".$IdPref."#");
						
						if ($pos === false) {
							$prefNewLst = $prefNewLst."#".$IdPref."#";
							$sql = "UPDATE tb_utente SET preferiti = '".$prefNewLst."' WHERE email = '".$_SESSION["user"]."'";
							
							if ($conn->query($sql) === TRUE) {
								echo "<h4>L'ambiente e' stato aggiunto correttamente ai tuoi preferiti</h4>";
							} else {
								echo "<p class='error'>Errore, non e' stato possibile aggiungere l'elemento ai preferiti: ".$conn->error."</p>\n";
							}
						} else {
							echo "<h4>L'ambiente selezionato era gia' presente nella tua lista dei preferiti</h4>";
						}
					}
				}
				
				
				$sql = "SELECT * FROM tb_utente WHERE email = '".$_SESSION["user"]."'";
				$result = $conn->query($sql);

                if ($result->num_rows <= 0) {
					echo "<p class='error'>Errore, query fallita. Numero elementi trovati: ".$result->num_rows."</p>\n";
                } else {
					$pref = $result->fetch_assoc();
					if (!isset($pref['preferiti'])) {
						echo "<h4>Elenco preferiti vuoto.</h4>";
						echo "<a href='gestione_ambiente.php'><button class='bottone'>Back</button></a>";
					} elseif ($pref['preferiti'] == ""){
						echo "<h4>Elenco preferiti vuoto.</h4>";
						echo "<a href='gestione_ambiente.php'><button class='bottone'>Back</button></a>";
					} else {
						$lstPref = explode("#", $pref['preferiti']);
						$firstItem = true;
						echo 	"<form method='POST' action='gestione_ambiente.php'>";
						foreach($lstPref as $tmp) {
							if ($tmp == "") {
								continue;
							}
							$sql = "SELECT * FROM tb_ambiente WHERE ID = '".$tmp."'";
							$result = $conn->query($sql);
							$row = $result->fetch_assoc();
							//<td><input type='submit' name='id' value=".$row['ID']."></td>
							echo "<div class='riquadro'>";
							echo "<p class='alcentro'>".$row['RagioneSociale']."</p>";
							echo "<p class='alcentro'>".$row['Indirizzo']."</p>";
							echo "<p class='alcentro'>".$row['Città']." - ".$row['Provincia']." - ".$row['CAP']."</p>";
							echo "<p class='alcentro'>".$row['TipoAmbiente']."</p>";
							echo "<button class='bottone' type='submit' name='id' value='V_".$row['ID']."'>VIEW</button>";
							echo "<br/></div><br/>";
						}
						echo "</form>";
					}
                }
				
				$_SESSION['ID_AMB_PREF'] = null;
                $conn->close();
            }

        } else {
			echo "<h2>Registrati o effettua il login per poter consultare i tuoi ambienti preferiti su QUICKUEUE</h2>";
        }
        ?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
