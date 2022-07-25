<?php ob_start();
echo '<h2 class="center">Log in</h2>';
if (isset($message)) {
	if ($success) {
		echo '<div class="alert success">' . $message . '</div>';
	} else {
		echo '<div class="alert error">' . $message . '</div>';
	}
} else {
	if (isset($flash) && $flash != '') {
		if ($flash['type'] != 'error') {
			echo '<div class="alert success">' . $flash['alert'] . '</div>';
		} else {
			echo '<div class="alert error">' . $flash['alert'] . '</div>';
		}
	}
}
?>
<form class="form" action="<?= ROOT_URL . "users/login" ?>" method="post">
	<label for="a_pseudo">Pseudo or email:</label>
	<input type="text" required name="a_pseudo" placeholder="Ex: senor16" value="<?= isset($fields['pseudo']) ? $fields['pseudo'] : '' ?>">
	<br>
	<label for="a_password">Password <small>(<a href="<?= ROOT_URL ?>restore">forgot password</a>)</small>:</label>
	<input type="password" required name="a_password" placeholder="yourpassword">
	<br>
	<label for="a_remember">
		<input type="checkbox" name="a_remember" id="a_remember" value="1">
		Remember ne</label>

	<input class="del-add" type="reset" value="Reset">
	<input class="del-add" type="submit" required name="login" value="Log in">
</form>
<?php
$content = ob_get_clean();
