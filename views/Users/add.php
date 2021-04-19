<?php
ob_start();
echo '<h2>'.$title.'</h2>';
if(isset($message)){
	if(!isset($errors)){
		echo '<div class="alert success">'.$message.'</div>';		
		if (isset($link)) echo '<p>Un vous a été envoyé par mail pour activer votre compte</p>';
	}else{
		echo '<div class="alert error">'.$message.'</div>';?>
		<form class="form" action="<?=ROOT_URL."users/add"?>" method="post">
		<?php
		if(isset($errors['pseudo'])){?>
			<label for="a_pseudo">Pseudo <small>(20 caratères au plus)</small>:</label>
			<?=$errors['pseudo']?>
			<input class="field-error" type="text" required name="a_pseudo" placeholder="Ex: senor16" value="<?=$fields['pseudo']?>">
			<br>
		<?php
		}else{?>
			<label for="a_pseudo">Pseudo <small>(20 caratères au plus)</small>:</label>
			<input type="text" required name="a_pseudo" placeholder="Ex: senor16" value="<?=$fields['pseudo']?>">
			<br>
		<?php
		}
		
		if(isset($errors['email'])){?>
			<label for="a_email">Email:</label>
			<?=$errors['email']?>
			<input class="field-error" type="email" required name="a_email" placeholder="Ex: senor16@gmail.com" value="<?=$fields['email']?>">
			<br>
		<?php }else{?>
			<label for="a_email">Email:</label>
			<input type="email" required name="a_email" placeholder="Ex: senor16@gmail.com" value="<?=$fields['email']?>">
			<br>			
		<?php }
		
		if(isset($errors['password'])){?>
			<label for="a_password">Mot de passe <small>(Au moins 4 caratères)</small>:</label>
			<?=$errors['password']?>
			<input class="field-error" type="password" required name="a_password" placeholder="votremotdepasse">
			<br>
		<?php }else{ ?>
			<label for="a_password">Mot de passe <small>(Au moins 4 caratères)</small>:</label>
			<input type="password" required name="a_password" placeholder="votremotdepasse">
			<br>			
		<?php }
		
		if(isset($errors['password_confirm'])){?>
			<label for="a_password_confirm">Confirmer votre mot de passe:</label>
			<?=$errors['password_confirm']?>
			<input class="field-error" type="password" required name="a_password_confirm" placeholder="votremotdepasse">		
		<?php }else{ ?>
				<label for="a_password_confirm">Confirmer votre mot de passe:</label>
				<input type="password" required name="a_password_confirm" placeholder="votremotdepasse">			
		<?php }		
		echo '	<br><input class="del-add" type="reset" value="Effacer">
				<input class="del-add" type="submit" required name="insert" value="S\'insrire">
				</form>';
	}
}
else{?>	
	<form class="form" action="<?=ROOT_URL."users/add"?>" method="post">
	<label for="a_pseudo">Pseudo <small>(20 caratères au plus)</small>:</label>
	<input type="text" required name="a_pseudo" placeholder="Ex: senor16">
	<br>
	<label for="a_email">Email:</label>
	<input type="email" required name="a_email" placeholder="Ex: senor16@gmail.com">
	<br>
	<label for="a_password">Mot de passe <small>(Au moins 4 caratères)</small>:</label>
	<input type="password" required name="a_password" placeholder="votremotdepasse">
	<br>
	<label for="a_password_confirm">Confirmer votre mot de passe:</label>
	<input type="password" required name="a_password_confirm" placeholder="votremotdepasse">	
	<br>	
	
	<label><input type="checkbox" name="a_remember" id="a_remember" value="1">
	Se souvenir de moi</label>
	
	<input class="del-add" type="reset" value="Effacer">
	<input class="del-add" type="submit" required name="insert" value="S'inscrire">
	
</form>
<?php }
$content=ob_get_clean();