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
    <meta name="description" content="Servizio per dati real-time affollamento ambienti.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Contatti - Quickueue</title>
    <link rel="stylesheet" href="stile.css">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main class="row">
      <h2>QUICKUEUE - Contattaci</h2>

        <h4>Scrivici a:</h4>
        <h4>supporto@quickueue.it</h4>
		<div class='alcentro'>
		<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d11272.612649534543!2d7.6623716!3d45.062404!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd97006264fbdaf1b!2sPolitecnico%20di%20Torino!5e0!3m2!1sit!2sit!4v1624428751895!5m2!1sit!2sit" class="mappe" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
		</div>
    </main>

    <?php require 'footer.php'; ?>
  </body>
</html>
