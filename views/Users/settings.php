<?php
ob_start();
require_once (ROOT."/views/layouts/functions.php");
echo '<a href="'.ROOT_URL.'settings"><h2 class="center">'.$title.'</h2></a> ';

switch($action):
  case 'main': ?>
  <ul class="settings">
    <li><h4><a href="<?=ROOT_URL?>settings/profile">Profil</a></h4>
    <li><h4><a href="<?=ROOT_URL?>settings/email">Changer d'email</a></h4>
    <li><h4><a href="<?=ROOT_URL?>settings/password">Changer le mot de passe </a></h4>
  </ul>

<?php
  break;
  case 'email':
    echo '<h3>Changer d\'adresse email</h3>';    
    if(isset($success)){
      if($success){
      	echo '<div class="alert success">'.$message.'</div>';
      	echo 'Un email vous a été envoyé pour confirmernvotre nouvelle adresse';
      }else{
      	echo '<div class="alert error">'.$message.'</div>';
      }
    }
?>
   <form class="form" action="" method="post">
	<label for="a_email">Nouvel email:</label>
	<?=isset($errors['email'])?$errors['email']:''?>
	<input type="email" required name="a_email" value="<?=isset($a_email)?$a_email:''?>" placeholder="Ex: senor16@gmail.com">

	<input class="del-add" type="reset" value="Effacer">
	<input class="del-add" type="submit" required name="email" value="Sauvegarder">
   </form>

<?php
  break;
  case 'password': ?>
	<h3>Changer de mot de passe</h3>
	<?php if(isset($success)){
      if($success){
      	echo '<div class="alert success">'.$message.'</div>';      	
      }else{
      	echo '<div class="alert error">'.$message.'</div>';
      }
    }
	?>
   <form class="form" action="" method="post">
	<label for="a_password">Mot de passe actuel:</label>
	<?=isset($errors['password'])?$errors['password']:''?>	
	<input type="password" required name="a_password" placeholder="motdepasseactuel">
	<br>
	<label for="a_new_password">Nouveau mot de passe <small>(Au moins 4 caratères)</small>:</label>
	<?=isset($errors['new_password'])?$errors['new_password']:''?>
	<input type="password" required name="a_new_password" placeholder="nouveaumotdepasse">
	<br>
	<label for="a_new_password_confirm">Confirmer votre nouveau mot de passe:</label>
	<?=isset($errors['new_password_confirm'])?$errors['new_password_confirm']:''?>
	<input type="password" required name="a_new_password_confirm" placeholder="nouveaumotdepasse">
	<br>
	<input class="del-add" type="reset" value="Effacer">
	<input class="del-add" type="submit" required name="passworf" value="Sauvegarder">
</form>
<?php
  break;
  case 'profile':?>
    <h3>Modifier votre profil</h3>
<?php
	if(isset($errors)){	
		if($errors==[]){
		  echo '<div class="alert success">'.$message.'</div>';
		}else{
		  echo '<div class="alert error">'.$message.'</div>';
		}
	}
?>
    <form class="form" action="" method="post">
		<label for="a_pseudo">Pseudo :</label>
       <?=isset($errors['pseudo'])? $errors['pseudo']:''?>
		<input type="text" required name="a_pseudo" value="<?= isset($fields['pseudo']) ? $fields['pseudo'] : $auth->a_pseudo?>" placeholder="Ex: senor16">
		<br>
  	   <label for="a_first_name">Prénom :</label>
		<?=isset($errors['first_name'])?$errors['first_name']:''?>
      <input type="text" required name="a_first_name" value="<?= isset($fields['first_name']) ? $fields['first_name'] : $auth->a_first_name?>" placeholder="Ex: Michée">
		<br>
       <label for="a_last_name">Nom:</label>
		<?=isset($errors['last_name'])?$errors['last_name']:''?>
      <input type="text" required name="a_last_name" value="<?= isset($fields['last_name']) ? $fields['last_name'] : $auth->a_last_name?>" placeholder="Ex: Sesso Kosga Bamokaï">
		<input class="del-add" type="reset" value="Effacer">
		<input class="del-add" type="submit" required name="passworf" value="Sauvegarder">
	</form>

<?php
  break;
endswitch;

$content=ob_get_clean();