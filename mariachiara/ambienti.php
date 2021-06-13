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
    
    <main class="row">

        <?php
        if (isset($_SESSION["user"])) {
            $conn = new mysqli("localhost", "root_utenti", "root_utenti", "mysql");
            if ($conn->connect_error)
                echo "<p class='error'>Siamo spiacenti ma c'è stato un errore connessione al database: ".$conn->connect_error."</p>\n";
            else{
                echo "<h2>I nostri ambienti associati</h2>";
                echo "<h4>In questa sezione puoi vedere tutti gli ambienti associati a QUIKUEUE.</h4>";				

                $sql = "SELECT * FROM tb_Ambiente WHERE 1=1";
				if (isset($_REQUEST['searchRagSoc']))
					$sql = $sql." AND RagioneSociale LIKE '%".$_REQUEST['searchRagSoc']."%'";
				if (isset($_REQUEST['searchCitta']))
					$sql = $sql." AND Città LIKE '%".$_REQUEST['searchCitta']."%'";
				if (isset($_REQUEST['searchProv']))
					$sql = $sql." AND Provincia LIKE '%".$_REQUEST['searchProv']."%'";
				if (isset($_REQUEST['TipoAmb'])) {
					if ($_REQUEST['TipoAmb'] != '')
						$sql = $sql." AND TipoAmbiente = '".$_REQUEST['TipoAmb']."'";
				}
				
				$result = $conn->query($sql);

                if ($result->num_rows <= 0) {
					echo "<p class='error'>Errore, query fallita. Numero elementi trovati: ".$result->num_rows."</p>\n";
					echo "<a href='gestione_ambiente.php'><button class='bottone'>Back</button></a>";
                } else {
					echo "<h4>Ci sono attivi: ".$result->num_rows." ambienti.</h4>";
					//echo "<table class='row'> <form action='visualizza_ambiente.php' method='POST'>";
					echo "<table class='row'> 
							<form action='gestione_ambiente.php' method='POST'>";
							
					$sql = "SELECT DISTINCT TipoAmbiente FROM tb_Ambiente";
					$ListTipoAmb = $conn->query($sql);
					
					echo "	<p>
								<label>Ragione Sociale: </label> 
								<input type='text' name='searchRagSoc' id='searchRagSoc' placeholder='Ragione Sociale'>
							</p>
							<p>
								<label>Citta': </label> 
								<input type='text' name='searchCitta' id='searchCitta' placeholder='Città'>
							</p>
							<p>
								<label>Provincia: </label> 
								<input type='text' name='searchProv' id='searchProv' placeholder='Provincia'>
							</p>";
					echo "	<p>
								<label>Tipologia Ambiente:</label> ";
					echo "<select name='TipoAmb' id='TipoAmb'>";
					echo "<option value=''></option>";
					while ($itemTipoAmb = $ListTipoAmb->fetch_assoc()) {
						echo "<option value='".$itemTipoAmb['TipoAmbiente']."'>".$itemTipoAmb['TipoAmbiente']."</option>";
					}
					echo "</select></p>";
					echo "<p><button type='submit' class='bottone'>Search</button></p>";
					//	
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
						//
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
					echo "</tbody>
							</form>
							</table>";
                }


                $conn->close();
            }

        } else {
			echo "<h2>Registrati o effettua il login per poter consultare gli ambienti registrati su QUIKUEUE</h2>";
        }
        ?>
    </main>
    
  </body>
</html>
