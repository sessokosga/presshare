<header>
		<h1 class="logo"><a href="<?=ROOT_URL?>">
		<img id="logo-share" src="<?=ROOT_URL?>svg/share-alt.svg"  class="svg" alt="logo">
		<img id="logo-clipboard" class="svg" src="<?=ROOT_URL?>svg/clipboard.svg" alt="logo">PressShare</a></h1>
		<form class="form-search" method="get" action="<?=ROOT_URL?>press/search">
			<input class="q-search" name="q" type="search" placeholder="Rechercher un Press">
			<button class="btn-search" type="submit"><img class="svg" src="<?=ROOT_URL?>svg/search.svg" alt="Rechercher"></button>			
		</form>
		<?php
			if(isset($_SESSION['auth'])):
		?>
			<ul class="menu">
				<li><a href="<?=ROOT_URL.'logout'?>">Déconnexion</a></li>
				<li><a href="<?=ROOT_URL.'settings'?>">Paramètres</a></li>
			</ul>
		<?php
			else:
		?>
			<ul class="menu">
				<li><a href="<?=ROOT_URL.'login'?>">Connexion</a></li>
				<li><a href="<?=ROOT_URL.'signup'?>">S'inscrire</a></li>
			</ul>
		<?php
			endif;			
		?>
	</header>