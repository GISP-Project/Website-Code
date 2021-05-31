<header class="row">
    <div class="col-12">
      <h1>QUIKUEUE</h1>
    </div>
</header>
<nav class="row">
    <div class="col-13 menuitem"><a href="home.php" title='Home page'>Home</a></div>
    <div class="col-13 menuitem"><a title='Login' 
		<?php
			if (!isset($_SESSION['user']))
				echo "href=login.php";
		 ?>>Login</a>
	 </div>
    <div class="col-13 menuitem"><a href="new.php" title="Registazione nuovo utente">Registrazione</a></div>
    <div class="col-13 menuitem"><a href="ambienti.php" title="Elenco ambienti">Ambienti</a></div>
	<div class="col-13 menuitem"><a href="preferiti.php" title="Elenco ambienti">Preferiti</a></div>
    <div class="col-13 menuitem"><a  title='Logout' 
		<?php
			if (isset($_SESSION['user']))
				echo "href=logout.php";
		?>>Logout</a>
	</div>
	<div class="col-13 menuitem">
		<?php
			if(!isset($_SESSION['user'])){
			  echo "<a title='Ospite'>GUEST</a>";
			}
			else {
			  echo "<a title='Sei autenticato'> ".$_SESSION['user']."</a>";
			}
		?>
	</div>
</nav>

