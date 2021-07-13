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
    <meta name="description" content="Pagina di dettaglio dell'ambiente selezionato.">
    <meta name="keywords" content="affollamento, covid19, real-time, prenotazione">
    <link rel="icon" href="favicon.png" type="image/png" >
    <title>Dettagli ambiente - QUICKUEUE</title>
    <link rel="stylesheet" href="stile.css">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main class="row">
		<?php
			if(isset($_REQUEST['id'])){
				$filtro = substr($_REQUEST['id'],0, 2);
				
				if ($filtro == "V_") {
					require 'visualizza_ambiente.php';
				}
				
				if ($filtro == "D_") {
										
					if(!$session){
						echo "<p class='error'>Le sessioni sono disabilitate!</p>";
					}else{
						if (isset($_SESSION["user"])) {
							$conn = new mysqli("localhost", "root_utenti", "root_utenti", "mysql");
							if ($conn->connect_error)
								echo "<p class='error'>Siamo spiacenti ma c'è stato un errore connessione al database: ".$conn->connect_error."</p>\n";
							else{
								$tmpIdDel = substr($_REQUEST['id'],2);
								$sql = "SELECT * FROM tb_Ambiente WHERE ID = '".$tmpIdDel."'";
								$resAmb = $conn->query($sql);
								
								if ($resAmb->num_rows <= 0) {
									echo "<p class='error'>Errore, query fallita. Non trovato l'elemento con ID: ".$tmpIdDel."</p>\n";
								} else {
									$row = $resAmb->fetch_assoc();
									$RagSoc = $row['RagioneSociale'];
									
									$sql = "SELECT * FROM tb_utente WHERE email = '".$_SESSION["user"]."'";
									$resUte = $conn->query($sql);
									
									if ($resUte->num_rows <= 0) {
										echo "<p class='error'>Errore, query fallita. Non trovato l'elemento con email: ".$_SESSION["user"]."</p>\n";
									} else {
										$row = $resUte->fetch_assoc();
										$ReplaceID = "#".$tmpIdDel."#";
										$prefNewLst = str_replace($ReplaceID, "", $row['preferiti']);
										$sql = "UPDATE tb_utente SET preferiti = '".$prefNewLst."' WHERE email = '".$_SESSION["user"]."'";
										if ($conn->query($sql) === TRUE) {
											echo "<h4>L'ambiente:</h4><h2>".$RagSoc."</h2>
												<h4>e' stato rimosso dai preferiti.</h4>";
										} else {
											echo "<p class='error'>Errore, non e' stato possibile aggiornare l'elenco preferiti: ".$conn->error."</p>\n";
										}	
									}
								}
								
								echo '
									<script>
										redirectTime = "1500";
										redirectURL = "preferiti.php";
										setTimeout("location.href = redirectURL;",redirectTime);
									</script>';
								
							}
						}
					}	
				}
			} else {
				require 'ambienti.php';
			}	
		?>
        
    </main>
    <?php require 'footer.php'; ?>
  </body>
</html>
