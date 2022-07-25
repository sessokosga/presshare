<header>
	<h1 class="logo"><a href="<?= ROOT_URL ?>">
			<img id="logo-share" src="<?= ROOT_URL ?>svg/share-alt.svg" class="svg" alt="logo">
			<img id="logo-clipboard" class="svg" src="<?= ROOT_URL ?>svg/clipboard.svg" alt="logo">PressShare</a></h1>
	<form class="form-search" method="get" action="<?= ROOT_URL ?>press/search/">
		<input class="q-search" name="q" type="search" placeholder="Search a Press">
		<button class="btn-search" type="submit"><img class="svg" src="<?= ROOT_URL ?>svg/search.svg" alt="Search"></button>
	</form>
	<?php
	if (isset($_SESSION['auth'])) :
	?>
		<ul class="menu">
			<li><a href="<?= ROOT_URL . 'users/logout' ?>">Log out</a></li>
			<li><a href="<?= ROOT_URL . 'users/settings' ?>">Settings</a></li>
		</ul>
	<?php
	else :
	?>
		<ul class="menu">
			<li><a href="<?= ROOT_URL . 'users/login' ?>">Log in</a></li>
			<li><a href="<?= ROOT_URL . 'users/signup' ?>">Sign up</a></li>
		</ul>
	<?php
	endif;
	?>
</header>