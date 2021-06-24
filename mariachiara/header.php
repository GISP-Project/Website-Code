<head>
    <link rel="stylesheet" href="nav_stile.css">    
</head>
<nav>
	
</nav>

<header class="row">

<!-- The overlay -->
	<div id="myNav" class="overlay">


		<!-- Button to close the overlay navigation -->
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>



		<!-- Overlay content -->
		<div class="overlay-content">
		 
			<?php 
				if (!isset($_SESSION['user'])) {
					echo "<a href='home.php'>Home</a>";
					echo "<a href='login.php'>Login</a>";
					echo "<a href='new.php'>Registrazione</a>";
					echo "<a href='contatti.php'>Contatti</a>";
				} else {
					if (!isset($_SESSION['ruolo'])) {
						echo "<a href='home.php'>Home</a>";
						echo "<a href='login.php'>Login</a>";
						echo "<a href='new.php'>Registrazione</a>";
						echo "<a href='contatti.php'>Contatti</a>";
					} else {
						if ($_SESSION['ruolo'] === "CLIENTE") {
							echo "<a href='home.php'>Home</a>";
							echo "<a href='profilo.php'>Profilo</a>";
							echo "<a href='gestione_ambiente.php'>Ambienti</a>";
							echo "<a href='preferiti.php'>Preferiti</a>";
							echo "<a href='listaPrenotazioniUtente.php'>Prenotazioni</a>";
							echo "<a href='listaPremi.php'>Premi</a>";
							echo "<a href='logout.php'>Logout</a>";
							echo "<a href='contatti.php'>Contatti</a>";
						}
						if ($_SESSION['ruolo'] === "ENTE") {
							echo "<a href='home.php'>Home</a>";
							echo "<a href='profiloEnte.php'>Profilo</a>";
							echo "<a href='listaPrenotazioniEnte.php'>Prenotazioni</a>";
							echo "<a href='datiIngressiEnte.php'>Affollamento</a>";
							echo "<a href='ricercaVoucherEnte.php'>Voucher</a>";
							echo "<a href='logout.php'>Logout</a>";
							echo "<a href='contatti.php'>Contatti</a>";
						}
					}
				}
			?>
		</div>
	</div>



	<!-- Use any element to open/show the overlay navigation menu -->
	<!--<div class="header">-->
		<!--<div class="trasparenza"></div>-->
		<!--<div class=titolo> Titolo sito</div>-->
		<!--<div class="container">-->
			<!--<div onclick="openNav()">
				 <div class="icona"></div>
				 <div class="icona"></div>
				 <div class="icona"></div>
			</div>-->
		<!--</div>-->
	<!--</div>-->




    <div class="col-12">
		<div onclick="openNav()">
			 <div class="icona"></div>
			 <div class="icona"></div>
			 <div class="icona"></div>
		</div>
		<h1>QUICKUEUE</h1>
		<?php
			if(!isset($_SESSION['user'])){
			  echo "<h5 class='utenteautenticato'>GUEST</h5>";
			}
			else {
			  echo "<h5 class='utenteautenticato'>".$_SESSION['user']."</h5>";
			}
		?>
    </div>
</header>

<script type="text/javascript">
/* Open when someone clicks on the span element */
function openNav() {
 document.getElementById("myNav").style.width = "350px";
}



/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
 document.getElementById("myNav").style.width = "0%";
}
</script>
