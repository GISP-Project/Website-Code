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
    <meta name="description" content="Registrati a QUICKUEUE per verificare in real-time gli affollamenti comodamente da casa tua.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Registrati - QUICKUEUE</title>
    <link rel="stylesheet" href="stile.css">
    <script type="text/javascript" src="validatore.js" ></script>
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main class="row">
      <h2>Iscriviti a QUICKUEUE</h2>
      <div class="centered"><p>Questa è la pagina di iscrizione. Inserisci il tuo indirizzo <strong>e-mail</strong> e scegli una <strong>password</strong> con i seguenti requisiti:
      <ul>
        <li>deve contenere solo caratteri alfabetici;</li>
        <li>deve contenere almeno una lettera maiuscola</li>
        <li>deve essere compresa tra 4 e 8 caratteri.</li>

      </ul></p></div>
      <form method="post" onsubmit="return validaForm(username.value, password1.value, password2.value, privacy)" action="iscrizione.php">
          <p class="alcentro"><label>E-mail* </label> <input type="text" name="username"></p>
          <p class="alcentro"><label>Password* </label> <input type="password" name="password1" id="passw1"  oninput='validaFormLiveLength("passw1", "livel");' ></p>
          <p class="alcentro"><output id="livel" ></p>
          <p class="alcentro"><label>Ripeti la password* </label><input type="password" name="password2" id="passw2"  oninput='validaFormLive("passw1", "passw2", "livep");'></p>
          <p class="alcentro"><output id="livep" ></p>
          <p class="alcentro"><label>Consenso al trattamento dei dati* </label><input type="checkbox" name="privacy" id="privacy"></p>
          <p class="alcentro"><input type="submit"><input type="reset"></p>
      </form>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
