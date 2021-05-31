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
    <meta name="description" content="Servizio per dati real-time affollamento ambienti.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Home - Quikueue</title>
    <link rel="stylesheet" href="stile.css">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main class="row">
      <h2>BENVENUTO IN QUIKUEUE</h2>
        <img src="coda.jpg" alt="Coda ingresso ambiente" />
        <br />
        <div class="centrato">
        <h3>La nostra APP...</h3>
        <p>Benvenuto su QUIKUEUE! Con la nostra app puoi visualizzare in real-time l'affollamento di, uffici, biblioteche... tutti i tuoi ambienti preferiti che solitamente frequenti. <br />
		Ti basta registrarti e accedere alla nostra app per non dover più aspettare in coda.<br />
		Prenota il tuo ingresso grazie al nostro servizio e esponi il QR Code ricevuto all'ingresso.</p>
        <br />

        <h3>...la nostra missione</h3>
        <p>Nasce con l’obiettivo di aiutare le persone a ridurre il tempo che trascorrono in coda o in luoghi affollati.<br />
		Questa situazione è stata ulteriormente esacerbata dallo scoppio della pandemia, che ha visto adottare misure di sicurezza atte a prevenire situazioni di affollamento. Situazione in cui qualsiasi attività aperta al pubblico ha dovuto gestire e contingentare gli accessi al pubblico.</p>
		<br />
        </div>

    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
