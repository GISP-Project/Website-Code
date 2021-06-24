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
    <title>Home - QUICKUEUE</title>
    <link rel="stylesheet" href="stile.css">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main class="row">
		
        <div class="centrato">		
		<iframe width="450" height="260" style="border: 1px solid #cccccc;" 
		src="https://thingspeak.com/channels/1403429/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15">
		</iframe>
        </div>

        <!--<div class="centrato">				
		https://api.thingspeak.com/channels/1403429/feeds.json?api_key=K82OA225Q0TS4EK5&results=1-->
		
		<?php
		$url = "https://api.thingspeak.com/channels/1403429/feeds.json?api_key=K82OA225Q0TS4EK5&results=1";
		
		//Se hai un URL e il tuo php lo supporta, puoi semplicemente chiamare file_get_contents:
		$data = file_get_contents($url);
		//se $ response è JSON, utilizzare json_decode per trasformarlo in array php:
		$response = json_decode($data);
		
		echo "<div class='centrato'>";
		print_r($response);
		echo "</div>";
		
		echo "<div class='centrato'>";
		//print_r($response->channel->id);
		//print_r($response->feeds[0]->field1);
		echo "<h4>Date: ".$response->feeds[0]->created_at."</h4>";
		echo "<h4>Num.Persone: ".$response->feeds[0]->field1."</h4>";
		echo "</div>";
		?>
		
		<!--</div>-->
		
		<script>
			redirectTime = "30000";
			redirectURL = "thingspeak.php";
			setTimeout("location.href = redirectURL;",redirectTime);
		</script>
		
		
		
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
