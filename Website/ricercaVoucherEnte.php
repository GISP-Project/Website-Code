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
    <meta name="description" content="Elenco degli ambienti che utilizzano QUICKUEUE.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Ricerca Voucher - QUICKUEUE</title>
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
                echo "<h2>Ricerca Voucher</h2>";	

				echo "<form action='ricercaVoucherEnte.php' method='POST'>";
				echo "	<p class='alcentro'>
							<label>Code Voucher: </label>
						</p>
						<p class='alcentro'>
							<input type='text' name='codeVoucher' id='codeVoucher' placeholder='Code'>
						</p>";
				echo "<p><button type='submit' class='bottone'>Search</button></p>";
				echo "</form>";
				
				if (isset($_POST["codeVoucher"])) {
					$sql = "SELECT * FROM tb_premi_acquisiti, tb_catalogo_premi 
							WHERE tb_premi_acquisiti.CodicePremio = tb_catalogo_premi.CodicePremio
							AND StatoVoucher = 'ATTIVO'
							AND CodiceVoucher = '".$_POST["codeVoucher"]."'";
					$result = $conn->query($sql);
					
					if ($result->num_rows <= 0) {
						echo "<p class='error'>Voucher non esistente: ".$_POST["codeVoucher"]."</p>\n";
					} else {
						$row = $result->fetch_assoc();
						
						echo "<br/><div class='riquadro'>";
						echo "<form action='accettaVoucherEnte.php' method='POST'>";
						echo "<p class='alcentro'>Trovato il Voucher avete code: </p>";
						echo "<h4>".$row["CodiceVoucher"]."</h4>";
						echo "<p class='alcentro'><b>Stato:</b> ".$row["StatoVoucher"]."</p>";
						echo "<p class='alcentro'><b>Utente:</b> ".$row["emailUtente"]."</p>";
						echo "<p class='alcentro'><b>Descrizione:</b> ".$row["DescrizionePremio"]."</p>";
						echo "<h4>Accetti il Voucher?</h4>";
						echo "<input type='hidden' id='codeVoucher' name='codeVoucher' value='".$_POST["codeVoucher"]."'>";
						echo "<p><button type='submit' class='bottone'>ACCETTA</button></p>";
						echo "</form>";
						echo "<br/></div><br/>";
					}
					
				}

                $conn->close();
            }

        } else {
			echo "<h2>Registrati o effettua il login per poter usufruire dei servizi di QUICKUEUE</h2>";
        }
        ?>
    </main>
    <?php require 'footer.php'; ?>
    
  </body>
</html>
