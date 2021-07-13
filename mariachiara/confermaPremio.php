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
				
				if(isset($_GET["CodPremio"])) {
					$sql = "SELECT * FROM tb_catalogo_premi WHERE CodicePremio = '".$_GET["CodPremio"]."'";				
					$result = $conn->query($sql);
					$premio = $result->fetch_assoc();
					$puntiRichiesti = $premio["PuntiRichiesti"];
					
					$sql = "SELECT * FROM tb_utente WHERE email = '".$_SESSION["user"]."'";				
					$result = $conn->query($sql);
					$utente = $result->fetch_assoc();
					$puntiUtente = $utente["punti"];
					
					if ($puntiUtente >= $puntiRichiesti) {
						$puntiResidui = $puntiUtente - $puntiRichiesti;
						
						
						// sql to update a record
						$sql = "UPDATE tb_utente SET punti = ".$puntiResidui." WHERE email = '".$_SESSION["user"]."'";

						if ($conn->query($sql) === TRUE) {
							
							$codiceVoucher = md5(uniqid($_SESSION["user"], true));
							
							// sql to update a record
							$sql = "INSERT INTO tb_premi_acquisiti (CodicePremio, emailUtente, CodiceVoucher, StatoVoucher)
									VALUES ('".$premio['CodicePremio']."','".$_SESSION["user"]."','".$codiceVoucher."','ATTIVO')";
							if ($conn->query($sql) === TRUE) {
								
							} 
							
							$nome_mittente = "QUICKUEUE";
							$mail_mittente = "server@mail.com";
						
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
									<h1>Dati del premio acquisito</h1>
									<p>Descrizione: ".$premio["DescrizionePremio"]."</p>
									<p>Punti scalati: ".$puntiRichiesti."</p>
									<p>Punti residui: ".$puntiResidui."</p>
									<p>Voucher: ".$codiceVoucher."</p>
								</body>
							</html>
							";		
							$mail_destinatario = $_SESSION["user"];
							$mail_oggetto = "QUICKUEUE - Premio acquisito";

							if (mail($mail_destinatario, $mail_oggetto, $mail_corpo, $mail_headers))
							{
								echo "<h2>COMPLIMENTI - Premio acquisito</h2>";
								echo "<h4>Controlla se hai ricevuto via e-mail il voucher per il premio richiesto.</h4>";
								echo "<div class='riquadro'>";
								echo "<h4>Premio: ".$premio['DescrizionePremio']."</h4>";
								echo "<h4>Punti: ".$premio['PuntiRichiesti']."</h4>";
								echo "</div><br/>";
							} else {
								echo "Errore. Nessun messaggio inviato.";
							}
										
						} else {
							echo "<p class='error'>Siamo spiacenti ma c'è stato un errore connessione al database: ".$conn->connect_error."</p>\n";
						}
						
						
					
					} else {
						echo "<p class='error'>Impossibile acquisire il premio. Punti non sufficienti.</p>";
						echo "<p class='error'>Punti utente: ".$puntiUtente."</p>";
						echo "<p class='error'>Punti necessari: ".$puntiRichiesti."</p>";
					}
					


					echo "<a href='listaPremi.php'><button class='bottone'>Back</button></a>";
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
