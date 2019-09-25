<nav class="header">
<div class="logo">
	<a href="index.php"><img src='img/Logo.png'/></a>
	<a href="index.php"><h1 class="rainbow">ParticulAres</h1></a>	
</div>
	<div class="bar">
		<div class='left-header' >	
			<span id="inicio" class="redButton">
			<a href="index.php">Inicio</a>
			</span>

	<?php 
		require_once('include/config.php');
		require_once('include/FormularioBusqueda.php');
	?>
			<div class='search-header'> 
	<?php
			if (strcmp(basename($_SERVER['PHP_SELF']), "index.php") != 0){
				$form = new FormBusqueda;
				$form->gestiona();
			} 
	?>
			</div>
		</div>
		<div class='right-header'>
	<?php
		if (isset($_SESSION['login']) && $_SESSION['login'] === true){ 
			if (isset($_SESSION['es_admin']) && $_SESSION['es_admin'] == true){
				echo '<div class="redButton"><a href="admin.php">Panel de admin</a></div>';
			}
			if (isset($_SESSION['es_profesor']) && $_SESSION['es_profesor'] == true){
				echo '<div class="redButton"><a href="createAd.php">Añadir anuncio</a></div>';
				echo '<div class="redButton"><a href="myAds.php">Mis anuncios</a></div>';
			}
			echo '<div class="redButton"><a href="myCalendar.php">Mi calendario</a></div>';
			echo '<div class="redButton"><a href="chat.php">Mis chats</a></div>';
			echo '<div id="redButton"><form class="" method="POST" action="showMyProfile.php" id="">
						<input type="hidden" name="verperfil" value="'. $_SESSION['id'] .'">
						<input class="submitLinkProfile" type="submit" value="Mi Perfil">
					</form>
				</div>';
			echo '<div class="redButton"><a href="logOut.php">Salir</a></div>';
		} else {
			echo '<div class="redButton"><a href="logIn.php">LogIn</a></div>';
			echo '<div class="redButton"><a href="signIn.php">SignIn</a></div>';
		}
		?>
		</div>
	</div>
</nav>