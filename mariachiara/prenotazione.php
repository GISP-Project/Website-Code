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
    <meta name="description" content="Prenotazione appuntamento QUICKUEUE.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Prenotazione - Quickueue</title>
    <link rel="stylesheet" href="stile.css">

  </head>
  <body>
    <?php require 'header.php'; ?>
    <main class="row">

        <?php
        if (isset($_SESSION["user"])) {
			
			if(isset($_GET["RagSocPren"])) 
				$RagSocPren = $_GET["RagSocPren"];
			if(isset($_GET["IdPren"])) 
				$IdPren = $_GET["IdPren"];
			if(isset($_REQUEST["RagSocPren"])) 
				$RagSocPren = $_REQUEST["RagSocPren"];
			if(isset($_REQUEST["IdPren"])) 
				$IdPren = $_REQUEST["IdPren"];
			
			echo "<h2>".$RagSocPren."</h2>";
			echo "<h2>Seleziona data e ora di prenotazione</h2>";
			echo '<form method="post" onsubmit="return validaPrenotazione(dtPrenotazione.value)" action="prenotazione.php">
				  <p class="alcentro">
					  <label>Scegli data e ora della tua prenotazione</label>
					  <input type="datetime-local" name="dtPrenotazione" id="dtPrenotazione">
					  <input id="RagSocPren" name="RagSocPren" type="hidden" value="'.$RagSocPren.'">
					  <input id="IdPren" name="IdPren" type="hidden" value="'.$IdPren.'">
				  </p>';
			echo  '<p class="alcentro"><input type="submit" value="PRENOTA"></p>
					</form>';
			echo "<a href='home.php' title='Home' class='bottone'>Torna home >></a>";;
        } else {
			echo "<h2>Registrati o effettua il login per poter prenotare l'accesso agli ambienti registrati su QUICKUEUE</h2>";
        }
		
		if (isset($_REQUEST["dtPrenotazione"])) {
			$dataPrenotazione = str_replace('-', '', $_REQUEST["dtPrenotazione"]);
			$dataPrenotazione = str_replace('T', '', $dataPrenotazione);
			$dataPrenotazione = str_replace(':', '', $dataPrenotazione);
			//echo "<h2>Data prenotazione: ".$_REQUEST["dtPrenotazione"]."</h2>";
			
			$dataAttuale = date("YmdHi");
			//echo "<h2>Data attuale: ".$dataAttuale."</h2>";
			
			$dtPren = (int)$dataPrenotazione;
			$dtNow = (int)$dataAttuale;
			//echo "<p>".$dtPren." - ".$dtNow."</p>";
			
			$codicePrenotazione = md5(uniqid($_SESSION["user"], true));
			
			if ($dtPren <= $dtNow) {
				echo "<h2>La data selezionata deve essere futura. Impossibile effettuare la prenotazione.</h2>";
			} else {
				
				$conn = new mysqli("localhost", "root_utenti", "root_utenti", "mysql");
				if ($conn->connect_error)
					echo "<p class='error'>Siamo spiacenti ma c'è stato un errore connessione al database: ".$conn->connect_error."</p>\n";
				else{
					$sql = "INSERT INTO tb_prenotazione (idPrenotazione, emailUtente, idAmbiente, RagSocAmbiente, dataoraPrenotazione, statoPrenotazione)
							VALUES ('".$codicePrenotazione."', '".$_SESSION["user"]."', '".$IdPren."', '".$RagSocPren."', '".$dataPrenotazione."', 'ATTIVA')";

					if ($conn->query($sql) === false) {
						echo "Error: " . $sql . "<br>" . $conn->error;
					} else {
						$nome_mittente = "QUICKUEUE";
						$mail_mittente = "marcocorvaglia@hotmail.com";

						$mail_headers = "From: " .  $nome_mittente . " <" .  $mail_mittente . ">\r\n";
						$mail_headers .= "Reply-To: " .  $mail_mittente . "\r\n";
						$mail_headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
						$mail_headers .= "MIME-Version: 1.0\r\n";
						$mail_headers .= "Content-type: text/html; charset=iso-8859-1";

						$mail_corpo = "
						<html>
							<head>
								<title>QUICKUEUE</title>
							</head>
							<body>
								<h1>Dati della prenotazione</h1>
								<p class='alcentro'>Ambiente: ".$RagSocPren."</p>
								<p class='alcentro'>Data/ora prenotazione: ".$_REQUEST["dtPrenotazione"]."</p>
								<p class='alcentro'>Codice prenotazione: ".$codicePrenotazione."</p>
							</body>
						</html>
						";		
						$mail_destinatario = $_SESSION["user"];
						$mail_oggetto = "QUICKUEUE - Prenotazione ingresso";

						if (mail($mail_destinatario, $mail_oggetto, $mail_corpo, $mail_headers))
						{
						echo "<h2>Prenotazione effettuata.</h2>
						  <h4>Controlla il tuo indirizzo e-mail, dovresti aver ricevuto il barcode da prensentare all'ingresso.</h4>";
						} else {
						echo "Errore. Nessun messaggio inviato.";
						}
					}

					$conn->close();
					
					echo '<script>
							redirectTime = "5000";
							redirectURL = "home.php";
							setTimeout("location.href = redirectURL;",redirectTime);
						</script>';
				}
			}
			
		}
        ?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
