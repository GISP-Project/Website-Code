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
    <meta name="description" content="Grazie per aver usufruito del nostro servizio di prestito.">
    <meta name="keywords" content="bioblioteca, library, libro, book, prestito, online, restituzione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Restituzione - Biblioteca online</title>
    <link rel="stylesheet" href="stile.css">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main class="row">
        <?php
        if (!$session) {
          echo "<p>Le sessioni sono disabilitate! Abilitale per avere un'eseperienza di navigazione più completa</p>";
        } else {
          $con = mysqli_connect("localhost", "uReadWrite", "SuperPippo!!!", "biblioteca");
          if (mysqli_connect_errno()) {
              echo "<p>Siamo spiacenti ma c'è stato un errore connessione al database: ".mysqli_connect_error()."</p>\n";
            }else{
              if (isset($_REQUEST['id'])) {
                $query= "UPDATE books SET prestito='', data='0000-00-00 00:00:00', giorni='0' WHERE id='".$_REQUEST['id']."'";
                $result = mysqli_query($con, $query);

                if (!$result) {
                  echo "<p>Errore query fallita: ".mysqli_error($con)."</p>\n";
                } else {
                  $_SESSION['nlibri'] -=1;
                  $oggi = time();
                  $data = strtotime($_REQUEST['data']);
                  $durata= $oggi - $data;
                  $durata= round($durata / (60 * 60 * 24));

                  echo "<p class='centrato'>Il libro è stato restituito correttamente !
                            Hai tenuto il libro per ".$durata." giorni </p>\n";
                  echo "<a href='libri.php' title='Sezione personale' class='bottone'>Torna alla pagina libri >></a>";
                  }

              } else {
                echo "<p class='error'>C'è stato un errore nell'invio dei dati
                        per la restituzione</p>\n";
                echo "<a href='libri.php' title='Sezione personale' class='bottone'>Torna alla pagina libri >></a>";
              }



            }
            mysqli_close($con);
        }

         ?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
