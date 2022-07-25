<?php
/*	
	Show press in a rounded div
*/
function showPresDiv($press)
{

	ob_start();
	$id = isset($_SESSION['auth']->a_id) ? $_SESSION['auth']->a_id : '';

	echo '<div class= "parent-press ">';
	foreach ($press as $pres) {
		echo '<div class= "press ' . strtolower($pres->genre) . ' "><b>' . $pres->title . '</b>';

		if (isset($pres->author) && $id == $pres->author) {
			echo '<a class="edit" href= "' . ROOT_URL . 'press/update/' . $pres->id . '" title= "Editer "><img src= "' . ROOT_URL . 'svg/edit.svg " alt= "Editer "></a>
				<a href= "' . ROOT_URL . 'press/deletepress/' . $pres->id . '" title= "Supprimer "><img src= "' . ROOT_URL . 'svg/trash-alt.svg" alt= "Supprimer "></a>';
		}

		echo '<br><small>' . $pres->date . '</small>';
		echo '<a class="genre" href="' . ROOT_URL . 'press/index/' . $pres->genre . 's">' . $pres->genre . '</a>';
		echo '<p>' . ($pres->genre === "Link" ? '<a href= "' . $pres->content . ' ">' . str_replace("\n", "<br>", $pres->content) . '</a>' : str_replace("\n", "<br>", $pres->content)) . '<br> </div>';
	}
	echo '</div>';
	return ob_get_clean();
}
