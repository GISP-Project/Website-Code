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
    <meta name="description" content="Grazie per aver preso in prestito i nostri libri e buona lettura.">
    <meta name="keywords" content="bioblioteca, library, libro, book, prestito, online, restituzione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Prestito - Biblioteca online</title>
    <link rel="stylesheet" href="stile.css">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main class="row">
        <?php
        if(!$session){
            echo "<p class='error'>Le sessioni sono disabilitate!</p>";
        }else{
          $con = mysqli_connect("localhost", "uReadWrite", "SuperPippo!!!", "biblioteca");
          if (mysqli_connect_errno()) {
              echo "<p class='error'>Siamo spiacenti ma c'è stato un errore connessione al database: ".mysqli_connect_error()."</p>\n";
            }else{
              if(isset($_REQUEST['id'])){
                if ($_SESSION['nlibri']==3) {
                  //se l'utente ha già tre libri in prestito
                  echo "<p class='error'>Siamo spiacenti ma non si possono avere più di 3 libri in prestito, restituiscine
                  qualcuno così potrai leggerne di nuovi!</p>";
                  echo "<a href='libri.php' title='Sezione personale' class='bottone'>Torna alla pagina libri >></a>";
                }

                elseif($_SESSION['nlibri']==2) {
                  //se l'utente ha 2 libri in prestito
                  if((count($_REQUEST['id']))>1){
                    echo "<p class='error'>Siamo spiacenti ma attualmente hai ".$_SESSION['nlibri']." libri in prestito
                    quindi al massimo puoi prendere 1 nuovo libro in prestito.</p>";
                    echo "<a href='libri.php' title='Sezione personale' class='bottone'>Torna alla pagina libri >></a>";
                  }else{
                    $id =$_REQUEST['id'];
                    $giorni= $_REQUEST['ngiorni'];

                    foreach( $giorni as $key => $val){
                      foreach ($id as $k => $value) {
                        if($value==$key){
                        if ( $giorni[$key]>0 && preg_match("/^\d+$/",trim($giorni[$key]))) {
                          $query= "UPDATE books SET prestito='".$_SESSION['user']."', data=NOW(), giorni='".$giorni[$key]."' WHERE id='".$value."' ";
                          $result = mysqli_query($con, $query);

                          if (!$result) {
                            echo "<p class='error'>Errore query fallita: ".mysqli_error($con)."</p>\n";
                          } else {
                            $_SESSION['nlibri']+=1;
                          }
                          echo "<p class='centrato'>Il prestito del ".($k+1)."° libro richiesto è andato a buon fine </p>";

                        }
                        else{
                          echo "<p class='error'>Il prestito del ".($k+1)."° libro richiesto non è andato a buon fine poiché il numero di giorni inserito è errato</p>";
                        }
                      }
                    }

                  }
                    echo "<a href='libri.php' title='Sezione personale' class='bottone'>Torna alla pagina libri >></a>";
                }
                } elseif($_SESSION['nlibri']==1){
                  //se l'utente ha 1 libro in prestito
                  if((count($_REQUEST['id']))>2){
                    echo "<p class='error'>Siamo spiacenti ma attualmente hai ".$_SESSION['nlibri']." libri in prestito
                    quindi al massimo puoi prendere 2 nuovi libri in prestito.</p>";
                  }else{
                    $id =$_REQUEST['id'];
                    $giorni= $_REQUEST['ngiorni'];

                    foreach( $giorni as $key => $val){
                      foreach ($id as $k => $value) {
                        if($value==$key){
                        if ( $giorni[$key]>0 && preg_match("/^\d+$/",trim($giorni[$key]))) {
                          $query= "UPDATE books SET prestito='".$_SESSION['user']."', data=NOW(), giorni='".$giorni[$key]."' WHERE id='".$value."' ";
                          $result = mysqli_query($con, $query);

                          if (!$result) {
                            echo "<p>Errore query fallita: ".mysqli_error($con)."</p>\n";
                          } else {
                            $_SESSION['nlibri']+=1;
                          }
                          echo "<p class='centrato'>Il prestito del ".($k+1)."° libro richiesto è andato a buon fine </p>";

                        }
                        else{
                          echo "<p class='error'>Il prestito del ".($k+1)."° libro richiesto non è andato a buon fine poiché il numero di giorni inserito è errato</p>";
                        }
                      }
                    }

                    }
                    echo "<a href='libri.php' title='Sezione personale' class='bottone'>Torna alla pagina libri >></a>";
                  }
                }elseif ($_SESSION['nlibri']==0) {
                  //se l'utente ha zero libri in prestito
                  if((count($_REQUEST['id']))>3){
                    echo "<p class='error'>Siamo spiacenti ma anche se attualmente hai ".$_SESSION['nlibri']." libri in prestito,
                     al massimo puoi prendere 3 nuovi libri in prestito.</p>";
                     echo "<a href='libri.php' title='Sezione personale' class='bottone'>Torna alla pagina libri >></a>";
                  }else{
                    $id =$_REQUEST['id'];
                    $giorni= $_REQUEST['ngiorni'];

                    foreach( $giorni as $key => $val){
                      foreach ($id as $k => $value) {
                        if($value==$key){
                        if ( $giorni[$key]>0 && preg_match("/^\d+$/",trim($giorni[$key]))) {
                          $query= "UPDATE books SET prestito='".$_SESSION['user']."', data=NOW(), giorni='".$giorni[$key]."' WHERE id='".$value."' ";
                          $result = mysqli_query($con, $query);

                          if (!$result) {
                            echo "<p>Errore query fallita: ".mysqli_error($con)."</p>\n";
                          } else {
                            $_SESSION['nlibri']+=1;
                          }
                          echo "<p class='centrato'>Il prestito del ".($k+1)."° libro richiesto è andato a buon fine </p>";

                        }
                        else{
                          echo "<p class='error'>Il prestito del ".($k+1)."° libro richiesto non è andato a buon fine poiché il numero di giorni inserito è errato</p>";
                        }
                      }
                    }

                    }
                    echo "<a href='libri.php' title='Sezione personale' class='bottone'>Torna alla pagina libri >></a>";
                  }
                }
              } else{
                echo "<p class='error'>Attenzione devi selezionare almeno un libro per il prestito!</p>";
                echo "<a href='libri.php' title='Sezione personale' class='bottone'>Torna alla pagina libri >></a>";
              }
              }
              }


         ?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
