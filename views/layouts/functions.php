<?php
/*
	Fonction qui affihe les Press dans des div ave des bords arrondis
*/
function showPresDiv($press){
	ob_start();
	echo '<div class= "parent-press ">';
	foreach ($press as $pres){
		echo '<div class= "press '.strtolower($pres->genre).' "><b>'.$pres->title.'</b>';
		echo '<p>'.($pres->genre ==="Link"? '<a href= "'.$pres->content.' ">'.$pres->content.'</a>' : $pres->content).'<br> <a class="genre" href="'.ROOT_URL.'press/index/'.$pres->genre.'s">'.$pres->genre.'</a> </p>		
		<p><small>'.$pres->date.'</small><a class="edit" href= "'.ROOT_URL.'/press/update/'.$pres->id.'" title= "Editer "><img src= "'.ROOT_URL.'svg/edit.svg " alt= "Editer "></a>
		<a href= "'.ROOT_URL.'press/deletepress/'.$pres->id.'" title= "Supprimer "><img src= "'.ROOT_URL.'svg/trash-alt.svg" alt= "Supprimer "></a></p></p></div>';
	}
	echo '</div>';
	return ob_get_clean();
}