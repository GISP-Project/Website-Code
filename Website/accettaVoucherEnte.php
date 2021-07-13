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
				echo "<h2>Accettazione Voucher</h2>";
				
				if (isset($_POST["codeVoucher"])) {
					$sql = "UPDATE tb_premi_acquisiti 
							SET StatoVoucher = 'CHIUSO' 
							WHERE CodiceVoucher = '".$_POST["codeVoucher"]."'";
					if ($conn->query($sql) === TRUE) {
						echo "<p class='alcentro'>Il Code Voucher:</p>";
						echo "<h4>".$_POST["codeVoucher"]."</h4>";
						echo "<p class='alcentro'>e' stato accettato.</p>";
					} else {
						echo "<p class='error'>Non e' stato possibile effettuare l'accettazione del Voucher ".$_POST["codeVoucher"].". Errore: ".$conn->error."</p>\n";
					}
				} else {
					echo "<p class='error'>ATTENZIONE: Non e' presente alcun Code Voucher. </p>\n";
				}
                	
				
				echo "<a href='ricercaVoucherEnte.php'><button class='bottone'>Back</button></a>";

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
