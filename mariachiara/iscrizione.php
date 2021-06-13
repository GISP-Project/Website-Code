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
    <meta name="description" content="Grazie per esserti registrato a QUIKUEUE.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Esito registrazione - QUIKUEUE</title>
    <link rel="stylesheet" href="stile.css">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main class="row">
        <?php
        if(isset($_REQUEST['username']) && isset($_REQUEST['password1']) && isset($_REQUEST['password2']) ){
          $username= trim($_REQUEST['username']);
          $password1= trim($_REQUEST['password1']);
          $password2= trim($_REQUEST['password2']);
		  $preferiti= "";
		  $ruolo= "CLIENTE";
		  $punti= 0;
          if (strlen($username)>=3 && strlen($username)<=100 && strlen($password1)>=4
              && strlen($password1)<=8 && $password1==$password2
              && preg_match("/^[[:alpha:]]{4,8}$/", $password1) && preg_match("/[a-z]/", $password1)
              && preg_match("/[A-Z]/", $password1) ) {
                $con = mysqli_connect("localhost", "root_utenti", "root_utenti", "mysql");
                if (mysqli_connect_errno()) {
                    echo "<p class='error'>Siamo spiacenti ma c'è stato un errore connessione al database: ".mysqli_connect_error()."</p>\n";
				}else{
					$query = "INSERT INTO tb_utente(email,pwd,preferiti,ruolo,punti) VALUES (?,?,?,?,?)";
					$stmt = mysqli_prepare($con, $query);
					mysqli_stmt_bind_param($stmt,"ssssi", $username, $password1, $preferiti, $ruolo, $punti);
					$result = mysqli_stmt_execute($stmt);
					if(!$result){
						if (mysqli_errno($con) == 1062) {
							echo "<p class='error'>Lo username inserito esiste già</p>";
						  }else{
							echo "<p class='error'>Errore query fallita: ".mysqli_error($con)."</p>\n";
							}
					  }
					else
						echo "<h2>Dati inseriti con successo!</h2>";
						if(!isset($_SESSION['user'])){
						echo "<a href='login.php' title='Login' class='bottone'>Effettua il login >></a>";
					  }else {
						echo " <a href='home.php' title='Sezione personale' class='bottone'>Torna alla pagina home >></a>";
					  }

					mysqli_stmt_close($stmt);
				}
				mysqli_close($con);
          }else{

          echo "<ul class='error'>";

          if (strlen($username)<3) {
            echo"<li>Lo username è troppo breve deve essere lungo almeno 3 caratteri!</li>";
          }
          if (strlen($username)>100) {
            echo"<li>Lo username è troppo lungo, non può superare i 100 caratteri</li>";
          }
          if (strlen($password1)<4) {
            echo"<li>La password è troppo corta, deve essere lunga almeno 4 caratteri</li>";
          }
          if (strlen($password1)>8) {
            echo"<li>La password è troppo lunga, non può superare gli 8 caratteri</li>";
          }
          if ($password1!=$password2) {
            echo"<li>Le password non corrispondono</li>";
          }
          if (!preg_match("/^[[:alpha:]]{4,8}$/", $password1)) {
            echo"<li>La password può contenere solo caratteri alfabetici</li>";
          }
          if (!(preg_match("/[a-z]/", $password1))) {
            echo"<li>La password deve contenere almeno una minuscola</li>";
          }
          if (!(preg_match("/[A-Z]/", $password1))) {
            echo"<li>La password deve contenere almeno una maiuscola</li>";
          }

          echo "</ul>";
          }
        }
         ?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
