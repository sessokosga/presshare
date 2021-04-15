<?php
ob_start();
if(isset($success)){
	if($success){
		echo '<div class="alert success">'.$message.'</div>';
	}else{
		echo '<div class="alert error">'.$message.'</div>';
	}
}
echo '	
	<div id="add-press" class="add-press">
		<h2>Modifier un Press </h2>
		<form method="post" class="form-press" action="'.ROOT_URL.'press/update/'.$press->id.'">
			<div class="form-press-left">
				<label for="p.title">Titre :</label> 
				<input value="'.$press->title.'" minlength="1" maxlength="25" required type="text" id="p.title" name="p.title" placeholder="Entrer un titre"><br>
				<label for="p.content">Contenu :</label>
				<textarea  minlength="2" required id="p.content" name="p.content" placeholder="Contenu du Press" cols="30" rows="5">'.$press->content.'</textarea><br>
			</div>
			<div class="form-press-right">
			<label for="p.genre">Type :</label>
				<select required id="p.genre" name="p.genre">';
if($press->genre === "Text"){
	echo '<option selected value="Text">Texte</option>
		<option value="Link">Lien</option>';
}else{
	echo '<option value="Text">Texte</option>
		<option selected value="Link">Lien</option>';
}					
echo '
				</select><br>
				<input class="del-add" type="reset" value="Effacer">
				<input class="del-add" type="submit" name="update" value="Enregistrer">
			</div>
		</form>
	</div>
	';
$content=ob_get_clean();
$script = $this->loadScript('add-press');