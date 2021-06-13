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
    <meta name="description" content="Accedi alla tua pagina personale per vedere i tuoi dati.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Profilo - QUIKUEUE</title>
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
				$sql = "SELECT * FROM tb_utente WHERE email='".$_SESSION['user']."'";
				$result = $conn->query($sql);
				$utente = $result->fetch_assoc();
				
				echo "<h2>Il tuo profilo</h2>";
				
				echo "	<p>
							<label>E-mail: </label> 
							<input type='text' value='".$utente['email']."' readonly>
						</p>
						<p>
							<label>Punti: </label> 
							<input type='text' value='".$utente['punti']."' readonly>
						</p>";
				echo "<a href='cancella_profilo.php'><button class='bottone'>DELETE</button></a>";
				
				
				$conn->close();
			}
		}
	  
	  
	  
	  


		?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
