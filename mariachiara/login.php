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
    <meta name="description" content="Accedi alla tua pagina personale per vedere affollamenti in real-time degli ambienti.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Login - QUIKUEUE</title>
    <link rel="stylesheet" href="stile.css">

  </head>
  <body>
    <?php require 'header.php'; ?>
    <main class="row">

      <?php
	  $username = "";
	  $password = "";
      if (isset($_SESSION['user'])) {
        echo "Hai effettuato il login, per cambiare utente prima effettuare il logout.";
      } else {
        echo "<h2>Effettua l'accesso a QUIKUEUE</h2>";
        echo '<form method="post" onsubmit="return validaLogin(username.value, password.value)" action="login.php">
              <p><label>Username </label> <input type="text" name="username"';
              if (isset($_COOKIE["user_cookie"])) {
                echo 'value="' .$_COOKIE["user_cookie"]. '">';
              }else{
                echo 'placeholder="Username" >';
              }
        echo  '</p>
              <p><label>Password </label> <input type="password" name="password" id="passw" placeholder="Password"></p>
              <p><input type="submit"><input type="reset"></p>
              </form>';
      }
	  
      if (!$session) {
        echo "le sessioni sono disabilitate";
      }else{
        if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){
          $username = trim($_REQUEST['username']);
		  $password = trim($_REQUEST['password']);
          $conn = new mysqli("localhost", "root_utenti", "root_utenti", "mysql");
          if ($conn->connect_error) {
              echo "<p class='error'>Siamo spiacenti ma c'è stato un errore connessione al database: ".$conn->connect_error."</p>\n";
            }else{
                $sql = "SELECT * FROM tb_utente WHERE email='".$username."' && pwd='".$password."'";
				$result = $conn->query($sql);
				$utente = $result->fetch_assoc();
				
				if ($result->num_rows > 0) {
					$_SESSION['user']=$username;
					$_SESSION['ruolo']=$utente['ruolo'];
					
					if ($_SESSION['ruolo'] == "ENTE") {
						$sql = "SELECT * FROM tb_Ambiente WHERE emailEnte='".$_SESSION["user"]."'";
						$result = $conn->query($sql);
						$dati = $result->fetch_assoc();
						$_SESSION['RagioneSocialeEnte'] = $dati["RagioneSociale"];
					}
					
					
					echo "<h2>Hai effettuato il login, per cambiare utente prima effettuare il logout.</h2>";
					echo "<a href='home.php' title='Home' class='bottone'>Torna home >></a>";
					echo '
						<script>
							redirectTime = "1500";
							redirectURL = "home.php";
							setTimeout("location.href = redirectURL;",redirectTime);
						</script>';
				} else {
					echo "<p class='error'>Lo username o la password inseriti risultano errati, riprova </p>";
				}
            }
            $conn->close();
          }

        }

       ?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
