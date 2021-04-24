<?php
ob_start();
echo '<h2 class="center">Reset password</h2>';    
    
	if(isset($success)){
      if($success){
      	echo '<p><div class="alert success">'.$message.'</div>';
      	echo 'An email was sent to your new address</p>';
      }else{
      	echo '<div class="alert error">'.$message.'</div>';
      }
    }
?>
   <form class="form" action="" method="post">
	<label for="a_email">Enter your email:</label>
	<?=isset($errors['email'])?$errors['email']:''?>
	<input <?=isset($errors['email'])?'class="field-error"':''?> type="email" required name="a_email" value="<?=isset($email)?$email:''?>" placeholder="Ex: senor16@gmail.com">

	<input class="del-add" type="reset" value="Reset">
	<input class="del-add" type="submit" required name="email" value="Next">
   </form>
<?php
$content= ob_get_clean();