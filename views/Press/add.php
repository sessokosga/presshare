<?php
ob_start();



if(isset($result['success'])){	
	if($result['success']){
		echo '<div class="alert success">'.$result['message'].'</div>';		
	}else{
		echo '<div class="alert error">'.$result['message'].'</div>';
	}
}
	?>
		<div id="add-press" class="add-press">
			<h2>Add a Press </h2>
			<form method="post" class="form-press" action="<?=ROOT_URL.'press/add?'?>">
			<div class="form-press-left">
				<label for="p.title">Title :</label> 
				<?=isset($result['errorInfo']['title'])?$result['errorInfo']['title']:''?>
				<input <?=isset($result['errorInfo']['title'])?'class = "field-error"':''?> value="<?=isset($result['title'])?$result['title']:''?>" minlength="1" maxlength="25" required type="text" id="p.title" name="p.title" placeholder="Add a title"><br>
				<label for="p.content">Content :</label>
				<textarea  minlength="2" required id="p.content" name="p.content" placeholder="Press content" cols="30" rows="5"><?=isset($result['content'])?$result['content']:''?></textarea><br>
			</div>
				<div class="form-press-right">
				<label for="p.genre">Genre :</label>
					<select required id="p.genre" name="p.genre">
						<?php
							if(isset($result['genre'])){
								if($result['genre'] === "Text"){
									echo '<option selected value="Text">Text</option>
										<option value="Link">Link</option>';
								}else{
									echo '<option value="Text">Text</option>
										<option selected value="Link">Link</option>';
								}					
							}else{ ?>
						<option value="Text">Text</option>
						<option value="Link">Link</option>
						<?php	
							}
						?>
					</select><br>
				<input class="del-add" type="reset" value="Reset">
					<input class="del-add" type="submit" name="insert" value="Add">
				</div>
			</form>
		</div>
<?php
$content=ob_get_clean();