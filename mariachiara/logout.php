<?php
$session = true;

if( session_status() === PHP_SESSION_DISABLED  )
$session = false;
elseif( session_status() !== PHP_SESSION_ACTIVE )
{
session_start();
}
  unset($_SESSION['user']);
  unset($_SESSION['ruolo']);
  unset($_SESSION['RagioneSocialeEnte']);
 ?>
 <!DOCTYPE html>
 <html lang="it" >
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width">
     <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=yes">
     <meta name="author" content="Mariachiara Mastrangelo">
     <meta name="description" content="Logout effettuato. Arrivederci!">
     <meta name="keywords" content="bioblioteca, library, libro, book, prestito, online, restituzione">
     <link rel="icon" href="favicon.png" type="image/png" >
     <title>Home - Biblioteca online</title>
     <link rel="stylesheet" href="stile.css">
   </head>
   <body>

     <main class="row">
       <?php
       if (!isset($_SESSION['user']) && !isset($_SESSION['ruolo']) && !isset($_SESSION['RagioneSocialeEnte'])) {
        echo  "<div><h2> Il logout ha avuto successo e verrai reindirizzato alla home page del sito, se ciò non accade clicca sul bottone</h2>
                </div>";
          echo '<script>
            redirectTime = "1500";
            redirectURL = "home.php";
        	  setTimeout("location.href = redirectURL;",redirectTime);
            </script>';
        echo "<a href='home.php' title='Home' class='bottone'>Torna home >></a>";
       } else {
        echo  "<h2 class='error'> Il logout non è andato a buon fine</h2>";
        echo "<a href='home.php' title='Home' class='bottone'>Torna home >></a>";
       }

        ?>

     </main>

   </body>
 </html>
