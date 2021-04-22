<?php
ob_start();
echo '<h2 class="center">'.$title.'</h2>';
if(isset($message)){
	if(!isset($errors)){
		echo '<div class="alert success">'.$message.'</div>';		
		if (isset($link)) echo '<p>Un vous a été envoyé par mail pour activer votre compte</p>';
	}else{
		echo '<div class="alert error">'.$message.'</div>';
	}
}
?>	
<form class="form" action="<?=ROOT_URL."signup"?>" method="post">	
	<label for="a_pseudo">Pseudo <small>(20 caratères au plus)</small>:</label>
	<?=isset($errors['pseudo'])?$errors['pseudo']:''?>
	<input type="text" required name="a_pseudo" value="<?=isset($fields['pseudo'])?$fields['pseudo']:''?>" placeholder="Ex: senor16">
	<br>
	<label for="a_email">Email:</label>
	<?=isset($errors['email'])?$errors['email']:''?>
	<input type="email" required name="a_email" value="<?=isset($fields['email'])?$fields['email']:''?>" placeholder="Ex: senor16@gmail.com">
	<br>
	<label for="a_password">Mot de passe <small>(Au moins 4 caratères)</small>:</label>
	<?=isset($errors['password'])?$errors['password']:''?>
	<input type="password" required name="a_password" placeholder="votremotdepasse">
	<br>
	<label for="a_password_confirm">Confirmer votre mot de passe:</label>
	<?=isset($errors['password_confrim'])?$errors['password_confrim']:''?>
	<input type="password" required name="a_password_confirm" placeholder="votremotdepasse">	
	<br>	
		
	
	<input class="del-add" type="reset" value="Effacer">
	<input class="del-add" type="submit" required name="login" value="S'inscrire">
	
</form>
<?php 
$content=ob_get_clean();