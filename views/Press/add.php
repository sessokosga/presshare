<?php
ob_start();


if(isset($result)){
	extract($result);
	if($success){
		echo '<div class="alert success">'.$message.'</div>';		
	}else{
		echo '<div class="alert error">'.$message.'</div>';
		echo '
			<div id="add-press" class="add-press">
			<h2>Ajouter un Press </h2>
			<form method="post" class="form-press" action="'.ROOT_URL.'press/add">
			<div class="form-press-left">
				<label for="p.title">Titre :</label> 
				'.$errorInfo['title'].'
				<input class="field-error" value="'.$title.'" minlength="1" maxlength="25" required type="text" id="p.title" name="p.title" placeholder="Entrer un titre"><br>
				<label for="p.content">Contenu :</label>
				<textarea  minlength="2" required id="p.content" name="p.content" placeholder="Contenu du Press" cols="30" rows="5">'.$content.'</textarea><br>
			</div>
			<div class="form-press-right">
			<label for="p.genre">Type :</label>
				<select required id="p.genre" name="p.genre">';
			if($genre === "Text"){
				echo '<option selected value="Text">Texte</option>
					<option value="Link">Lien</option>';
			}else{
				echo '<option value="Text">Texte</option>
					<option selected value="Link">Lien</option>';
			}					
		echo '
				</select><br>
				<input class="del-add" type="reset" value="Effacer">
					<input class="del-add" type="submit" name="insert" value="Ajouter">
				</div>
			</form>
		</div>';
	}
	
}else{
	echo '	
		<div id="add-press" class="add-press">
			<h2>Ajouter un Press </h2>
			<form method="post" class="form-press" action="'.ROOT_URL.'press/add">
				<div class="form-press-left">	
					<label for="p.title">Titre :</label> 			
					<input minlength="1" maxlength="25" required type="text" id="p.title" name="p.title" placeholder="Entrer un titre"><br>
					<label for="p.content">Contenu :</label>
					<textarea  minlength="2" required id="p.content" name="p.content" placeholder="Contenu du Press" cols="30" rows="5"></textarea><br>
				</div>
				<div class="form-press-right">
				<label for="p.genre">Type :</label>
					<select required id="p.genre" name="p.genre">
						<option value="Text">Texte</option>
						<option value="Link">Lien</option>
					</select><br>
				<input class="del-add" type="reset" value="Effacer">
					<input class="del-add" type="submit" name="insert" value="Ajouter">
				</div>
			</form>
		</div>';
}
$content=ob_get_clean();