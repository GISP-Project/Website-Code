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
    <meta name="description" content="Accedi alla tua pagina personale per vedere i tuoi dati.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Profilo - QUICKUEUE</title>
    <link rel="stylesheet" href="stile.css">

  </head>
  <body>
    <?php require 'header.php'; ?>
    <main class="row">

		<?php
		$username = "";
		$password = "";
		if (!isset($_SESSION['user'])) {
			echo "Hai effettuato il login, non puoi accedere alla tua pagina.";
		} else {
			$conn = new mysqli("localhost", "root_utenti", "root_utenti", "mysql");
			if ($conn->connect_error) {
			  echo "<p class='error'>Siamo spiacenti ma c'è stato un errore connessione al database: ".$conn->connect_error."</p>\n";
			}else{
				echo "<h2>".$_SESSION['user']."</h2>";
				
				// sql to delete a record
				$sql = "DELETE FROM tb_utente WHERE email='".$_SESSION['user']."'";

				if ($conn->query($sql) === TRUE) {
					echo "<h4>Il tuo profilo e' stato cancellato correttamente.</h4>";
				} else {
					echo "<p class='error'>Siamo spiacenti ma c'è stato un errore connessione al database: ".$conn->connect_error."</p>\n";
				}
				
				unset($_SESSION['user']);
				unset($_SESSION['ruolo']);
				unset($_SESSION['RagioneSocialeEnte']);
				
				echo '<script>
						redirectTime = "3500";
						redirectURL = "home.php";
						setTimeout("location.href = redirectURL;",redirectTime);
						</script>';
				
				$conn->close();
			}
		}
	  
	  
	  
	  


		?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
