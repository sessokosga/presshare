<?php
ob_start();
if(isset($result)){
	extract($result);
	if($success){
		echo '<div class="alert success">'.$message.'</div>';
	}else{
		echo '<div class="alert error">'.$message.'</div>';
	}
}

?>
	<div id="add-press" class="add-press">
		<h2>Edit a Press </h2>
		<form method="post" class="form-press" action="<?=ROOT_URL.'press/update/'.$press->id?>">
			<div class="form-press-left">
			<label for="p.title">Title :</label>
			<?=isset($errorInfo['title']) ? $errorInfo['title'] : ''?>
			<input <?=isset($errorInfo['title'])? 'class="field-error"' :'' ?> value="<?=isset($fields['title'])?$fields['title']:$press->title?>" minlength="1" maxlength="25" required type="text" id="p.title" name="p.title" placeholder="Enter titre"><br>

			<label for="p.content">Content :</label>
				<textarea  minlength="2" required id="p.content" name="p.content" placeholder="Contenu du Press" cols="30" rows="5"><?=isset($fields['content'])?$fields['content']:$press->content?></textarea><br>
			</div>
			<div class="form-press-right">
			<label for="p.genre">Genre :</label>
				<select required id="p.genre" name="p.genre">
					<?php
					if($press->genre === "Text"){
						echo '<option selected value="Text">Texte</option>
							<option value="Link">Lien</option>';
					}else{
						echo '<option value="Text">Texte</option>
							<option selected value="Link">Lien</option>';
					}					
					?>
				</select><br>
				<input class="del-add" type="reset" value="Reset">
				<input class="del-add" type="submit" name="update" value="Save">
			</div>
		</form>
	</div>
<?php
$content=ob_get_clean();