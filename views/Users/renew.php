<?php
ob_start();
?>

<h2 class="center">Set new password</h2>

<?php
if(isset($success)){
	if($success){
		echo '<div class="alert success">'.$message.'</div>';
	}else{
		echo '<div class="alert error">'.$message.'</div>';
	}
}
?>

<form class="form" action="" method="post">
	<label for="a_password">New password:</label>
	<?=isset($errors['password'])?$errors['password']:''?>	
	<input type="password" required name="a_password" placeholder="newpassword">
	<br>
	<label for="a_new_password_confirm">Confirm password:</label>
	<?=isset($errors['password_confirm'])?$errors['password_confirm']:''?>
	<input type="password" required name="a_password_confirm" placeholder="newpassword">
	<br>
	<input class="del-add" type="reset" value="Reset">
	<input class="del-add" type="submit" required name="password" value="Save">
</form>

<?php
$content = ob_get_clean();