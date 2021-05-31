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
    <meta name="description" content="Elenco degli ambienti che utilizzano QUIKUEUE.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Ambienti - Quikueue</title>
    <link rel="stylesheet" href="stile.css">

  </head>
  <body>
    <?php require 'header.php'; ?>
    <main class="row">

        <?php
        if (isset($_SESSION["user"])) {
            $conn = new mysqli("localhost", "root_utenti", "root_utenti", "mysql");
            if ($conn->connect_error)
                echo "<p class='error'>Siamo spiacenti ma c'è stato un errore connessione al database: ".$conn->connect_error."</p>\n";
            else{
                echo "<h2>I nostri ambienti associati</h2>";
                echo "<h4>In questa sezione puoi vedere tutti gli ambienti associati a QUIKUEUE.</h4>";

                $sql = "SELECT * FROM tb_Ambiente";
				$result = $conn->query($sql);

                if ($result->num_rows <= 0) {
					echo "<p class='error'>Errore, query fallita. Numero elementi trovati: ".$result->num_rows."</p>\n";
                } else {
					echo "<h4>Ci sono attivi: ".$result->num_rows." ambienti.</h4>";
					//echo "<table class='row'> <form action='visualizza_ambiente.php' method='POST'>";
					echo "<table class='row'> <form action='gestione_ambiente.php' method='POST'>";
					echo "	<thead class='hide'>
								<th>VIEW</th>
								<th>Ragione Sociale</th>
								<th>Indirizzo</th>
								<th>Città</th>
								<th>Prov.</th>
								<th>CAP</th>
								<th>Tipo Amb.</th>
							</thead>
							<tbody>";
					while ($row = $result->fetch_assoc()) {
						//<td><input type='submit' name='id' value='V".$row['ID']."'></td>
						echo "
							<thead class='show'><th>Ragione Sociale</th></thead>
							<tr>
								<td><button type='submit' name='id' value='V_".$row['ID']."'>".$row['ID']."</button></td>
								<td>".$row['RagioneSociale']."</td>
								<td>".$row['Indirizzo']."</td>
								<td>".$row['Città']."</td>
								<td>".$row['Provincia']."</td>
								<td>".$row['CAP']."</td>
								<td>".$row['TipoAmbiente']."</td>
							</tr>";
					}
					echo "</tbody></form></table>";
                }


                $conn->close();
            }

        } else {
			echo "<h2>Registrati o effettua il login per poter consultare gli ambienti registrati su QUIKUEUE</h2>";
        }
        ?>
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
